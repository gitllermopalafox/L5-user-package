<?php

namespace SidneyDobber\User;

use Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Mail\Message;

class PasswordController extends Controller {

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct (
        ResetPassword $reset_password_instance
    ) {
        $this->reset_password_instance = $reset_password_instance;
        $this->user_config = config('packages.SidneyDobber.User.user');
        $this->emails_config = config('packages.SidneyDobber.User.emails');
    }


    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail () {
        $view = $this->user_config['views']['request'];
        return view($view);
    }


    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail (Request $request) {
        $this->validate($request, ['email' => 'required|email']);
        // Set the credentials.
        $credentials = [
            "email" => Input::get("email")
        ];
        $user = Password::getUser($credentials);
        // Email attributes.
        $view = $this->emails_config['reset_password'];
        $sender = $this->emails_config['from_address'];
        $subject = $this->emails_config['reset_password_subject'];
        // Send the reset link to the user.
        $response = $this->reset_password_instance->sendResetMail ($view, $user, $sender, $subject);
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect('/admin')->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }


    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset ($token = null) {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        $view = $this->user_config['views']['reset'];
        return view($view)->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset (Request $request) {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });
        switch ($response) {
            case Password::PASSWORD_RESET:
                $url = $this->user_config['redirects']['reset'];
                return redirect($url)->with('status', trans($response));
            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

}
