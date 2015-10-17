<?php

namespace SidneyDobber\User;

use Validator, Input, Hash, Password, Config, Auth, Request, Message;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Auth\Passwords\TokenRepositoryInterface as TokenRepository;

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
        TokenRepository $tokens,
        MailerContract $mailer
    ) {
        // Setting the templates.
        $this->emails_config = config('emails');
        $this->new_user_template = $this->emails_config['new_user'];
        $this->reset_password_template = $this->emails_config['reset_password'];
        $this->tokens = $tokens;
        $this->mailer = $mailer;
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

            // Generate token.
            $token = $this->tokens->create($user);
            // Send the mail.
            $result = $this->emailResetLink($user, $token, $this->new_user_template);

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
     * Request user password.
     */
    public function request() {
        $rules = array(
            "email" => "required|email"
        );
        if($this->validate(Input::all(), $rules)) {
            $credentials = [
                "email" => Input::get("email")
            ];
            // Configure the template for the reset email.
            Config::set("auth.reminder.email", $this->reset_password_template);
            // Send the password reset email.
            Password::remind($credentials, function($message, $user) {
                $message->from($this->emails_config['from_address']);
                $message->subject($this->emails_config['reset_password_subject']);
            });
             return true;
        } else {
             return false;
        }
    }


    /**
     * Reset user password.
     */
    public function reset() {
        $rules = array(
            "email" => "required|email",
            "password" => "required|min:6",
            "password_confirmation" => "required|same:password",
            "token" => "required|exists:password_reminders,token"
        );
        if($this->validate(Input::all(), $rules)) {
             $credentials = [
                    "email" => Input::get("email"),
                    "password" => Input::get("password"),
                    "password_confirmation" => Input::get("password_confirmation"),
                    "token" => Input::get("token"),
             ];
            // Reset the the user with the new credentials.
            Password::reset($credentials, function($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                Auth::login($user);
            });
            return true;
        } else {
            return false;
        }
    }


    /**
     * Login user.
     */
    public function login() {
        $rules = array(
             "username" => "required",
             "password" => "required"
        );
        if($this->validate(Input::all(), $rules)) {
             $credentials = [
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
             ];
             if(Auth::attempt($credentials)) {
                    return true;
             } else {
                    return false;
             }
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
    public function emailResetLink($user, $token, $view, Closure $callback = null) {
        $this->mailer->alwaysFrom('codingyoda@gmail.com', 'tester');
        return $this->mailer->send($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForPasswordReset());
            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
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