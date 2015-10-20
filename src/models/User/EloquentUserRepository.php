<?php

namespace SidneyDobber\User;

use Validator, Input, Hash, Password, Config, Auth, Request;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Mail\Mailer as MailerContract;

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
        TokenRepositoryInterface $tokens,
        MailerContract $mailer
    ) {
        // Setting the templates.
        $this->emails_config = config('packages.SidneyDobber.User.emails');
        $this->new_user_template = $this->emails_config['new_user'];
        $this->reset_password_template = $this->emails_config['reset_password'];
        $this->mailer = $mailer;
        $this->tokens = $tokens;
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
        if($this->validate(Input::all(), $rules)) {
            $user = new User;
            $user->username = Input::get("username");
            $user->email = Input::get("email");
            $user->userrole = Input::get("userrole");
            $user->password = Hash::make(str_random(10));
            $user->save();
            // Set the credentials.
            $credentials = [
                "email" => Input::get("email")
            ];
            // Send the mail.
            // Password::sendResetLink($credentials, null);

            $token = $this->tokens->create($user);
            $this->emailResetLink($user, $token, null);

            // Custom success messages.
            $this->successes = array(
                "The new user <a href=\"/admin/users/" . $user->id . "\"/>" . $user->username . "</a> has been succesfully created."
            );
            return true;
        } else {
            return false;
        }
    }


    /**
     * Send the password reset link via e-mail.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return int
     */
    public function emailResetLink($user, $token, Closure $callback = null) {
        $view = 'user::emails.new-user';
        return $this->mailer->send($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForPasswordReset());
            $m->from('noreply@sidneydobber.com');
            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
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