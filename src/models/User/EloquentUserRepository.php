<?php

namespace SidneyDobber\User;

use Validator, Input, Hash, Password, Config, Auth, Request;

class EloquentUserRepository implements UserRepositoryInterface {

    /**
     * Instanse variables.
     */
    protected $errors;


    /**
     * Constructor.
     *
     * @param  UserRepositoryInterface $userInstance
     */
    public function __construct(
        ResetPassword $reset_password_instance
    ) {
        // Setting the templates.
        $this->emails_config = config('packages.SidneyDobber.User.emails');
        $this->reset_password_instance = $reset_password_instance;
    }


    /**
     * Get all instances.
     */
    public function readAll() {
        return User::paginate();
    }


    /**
     * Get instance by id.
     *
     * @param  int $id
     */
    public function read($id) {
            return User::find($id);
    }


    /**
     * Delete instance based on id.
     *
     * @param  int $id
     */
    public function delete($id) {
        User::destroy($id);
        // Custom success messages.
        $this->successes = array(
             "The user has been succesfully deleted."
        );
     }


    /**
     * Delete instance based on id.
     *
     * @param int $id
     */
    public function create() {
        $rules = array(
            "username" => "required|min:6|unique:users,username",
            "email" => "required|email|unique:users,email", 
            "userrole" => "required"
        );
        // Validate the input.
        $validated = $this->validate(Input::all(), $rules);
        // Store the new user if the email was send successfully.
        if($validated == true) {
            $user = new User;
            $user->username = Input::get("username");
            $user->email = Input::get("email");
            $user->userrole = Input::get("userrole");
            $user->password = Hash::make(str_random(10));
            $user->save();
            // Custom success messages.
            $this->successes = array(
                "The new user <a href=\"/admin/users/" . $user->id . "\"/>" . $user->username . "</a> has been succesfully created."
            );
            // Email attributes.
            $view = $this->emails_config['new_user'];
            $sender = $this->emails_config['from_address'];
            $subject = $this->emails_config['new_user_subject'];
            // Send the reset link to the new user.
            $response = $this->reset_password_instance->sendResetMail ($view, $user, $sender, $subject);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Delete instance based on id.
     *
     * @param User $user
     */
    public function update($user) {
        $rules = array(
            "email" => "required|email",
            "userrole" => "required"
        );
        if($this->validate(Input::all(), $rules)) {
            $user->save();
            // Custom success messages.
            $this->successes = array(
                "The user <a href=\"/admin/users/" . $user->id . "\">" . $user->username . "</a> has been succesfully updated."
            );
            return true;
        } else {
            return false;
        }
     }


    /**
     * Validator.
     *
     * @param array $data
     * @param array $rules
     */
    public function validate($data, $rules) {
        // Create new validator instance.
        $validator = Validator::make($data, $rules);
        if($validator->passes()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }


    /**
     * Accessor method for getting errors.
     */
    public function errors() {
        return $this->errors->all();
    }


    /**
     * Accessor method for getting errors.
     */
    public function successes() {
        return $this->successes;
    }

}