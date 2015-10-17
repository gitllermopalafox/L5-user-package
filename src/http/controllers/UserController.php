<?php

namespace SidneyDobber\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use View, Auth, Config, Input, Redirect, Password, Validator;

class UserController extends Controller {


    /**
     * Instanse variables.
     */
    public $userroles;


    /**
     * Constructor.
     *
     * @param  UserRepositoryInterface $userInstance
     */
    public function __construct(
        UserRepositoryInterface $userInstance
    ) {
        // Dependancy injected instances.
        $this->userInstance = $userInstance;
        // When a user is logged in share the variables with the view.
        if(Auth::user()) {
            $this->userroles = config('userroles');
            $this->userrole = $this->userroles[Auth::user()->userrole];
            $this->permissions = config('permissions');
        }
    }


    /**
     * Add user.
     */
    public function addUser() {
        // When the user is not authorized for the page show unauthorized page.
        if(AEUser::authorize('add-user') == false) {
            return view('user::auth.unauthorized');
        }
        // Initialize the data array that gets send to the view.
        $data = [
            "errors" => null,
            "userrole" => $this->userrole,
            "userroles" => $this->userroles,
            "permissions" => $this->permissions
        ];
        // When the form is posted.
        if(Input::server("REQUEST_METHOD") == "POST") {
            // If the input is valid set the credentials.
            if($this->userInstance->create()) {
                // Set the status message and set the status to true.
                $data["successes"] = $this->userInstance->successes();
                // Redirect to the user overview on success.
                return Redirect::to("/admin/users")
                    ->withInput($data);
            } else {
                // Flash the input for usage in the view.
                Input::flash();
                // Set the data errors variable.
                $data["errors"] = $this->userInstance->errors();
             }
        }
        return view('user::admin.user-add', $data);
    }


    /**
     * Get user.
     *
     * @param  int $id
     */
    public function user($id = null) {
        // Initialize the data array that gets send to the view.
        $data = [
            "errors" => null,
            "userrole" => $this->userrole,
            "userroles" => $this->userroles,
            "permissions" => $this->permissions
        ];
        // When the logged in users user name is not equal to the user variable authorize the user.
        if(Auth::user()->id != $id) {
            if(AEUser::authorize('user')) {
                    $user = $this->userInstance->read($id);
            } else {
                // When the user is not authorized for the page show unauthorized page.
                return view('user::auth.unauthorized');
            }
        } else {
            $user = Auth::user();
        }
        // When the form is posted.
        if(Input::server("REQUEST_METHOD") == "POST") {
            // Set the users email and user role so they are preset in the view.
            $user->email = Input::get("email");
            $user->userrole = Input::get("userrole");
            // If the input is valid update the user.
            if($this->userInstance->update($user)) {
                // Set the status message and set the status to true.
                $data["successes"] = $this->userInstance->successes();
                // Redirect to the user overview on success.
                return Redirect::to("/admin/users")
                    ->withInput($data);
            } else {
                // Set the errors variable.
                $data["errors"] = $this->userInstance->errors();
            }
        }
        // Set the data user role value and user variable.
        $data['user'] = $user;
        $data["userrole_value"] = $user->userrole;
        return view('user::admin.user', $data);
    }


    /**
     * Get users.
     */
    public function users() {
        // Initialize the data array that gets send to the view.
        $data = [
            "successes" => Input::old("successes"),
            "userrole" => $this->userrole,
            "userroles" => $this->userroles,
            "permissions" => $this->permissions
        ];
        // When the user is not authorized for the page show unauthorized page.
        if(AEUser::authorize('users') == false) {
            return view('user::auth.unauthorized');
        }
        // Set the data users variable.
        $data['users'] = $this->userInstance->readAll();
        return view('user::admin.user-all', $data);
     }


    /**
     * Delete user.
     *
     * @param  int $id
     */
    public function deleteUser($id = null) {
        // When the user is authorized delete the user else show unauthorized page.
        if(AEUser::authorize('users')) {
            $this->userInstance->delete($id);
            // Set the status message and set the status to true.
            $data["successes"] = $this->userInstance->successes();
            // Redirect to the user overview on success.
            return Redirect::to("/admin/users")
                ->withInput($data);
        } else {
            return view('user::auth.unauthorized');
        }
    }

}