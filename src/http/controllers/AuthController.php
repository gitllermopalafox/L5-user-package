<?php

namespace SidneyDobber\User;

use App\User;
use Validator;
use Auth;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct () {
    }


    /**
     * Render the dashboard.
     *
     * @return void
     */
    public function dashboard () {
        return view("user::admin.dashboard");
    }


    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin () {
        if(Auth::user()) {
            return Redirect::to("/admin/dashboard");
        }
        $view = config('user.views.login');
        return view($view);
    }


    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated (Request $request, $throttles) {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }
        if (method_exists ($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
        $url = config('user.redirects.login');
        return redirect()->intended($url);
    }


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout () {
        Auth::logout();
        $url = config('user.redirects.logout');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : $url);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator (array $data) {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }

}
