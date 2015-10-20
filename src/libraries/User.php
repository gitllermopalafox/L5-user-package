<?php

namespace SidneyDobber\User;

use Config, Auth;

class AEUser {

    /**
     * Authorize the user against the configuration.
     *
     * @param  string $on
     */
    public static function authorize($on) {
        $userroles = config('packages.SidneyDobber.User.userroles');
        $userrole = (Auth::user() != null ? $userroles[Auth::user()->userrole] : null);
        $permissions =  config('packages.SidneyDobber.User.permissions');
        return in_array($userrole, $permissions[$on]);
    }
}
