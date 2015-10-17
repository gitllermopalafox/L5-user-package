<?php

/*
|--------------------------------------------------------------------------
| Foobar.
|--------------------------------------------------------------------------
|
|
|
*/

// Authentication routes.
Route::get('/admin', 'SidneyDobber\User\AuthController@getLogin');
Route::post('/admin', 'SidneyDobber\User\AuthController@postLogin');

// Password reset link request routes.
Route::get('/request', 'SidneyDobber\User\PasswordController@getEmail');
Route::post('/request', 'SidneyDobber\User\PasswordController@postEmail');

// Password reset routes.
Route::get('/reset/{token}', 'SidneyDobber\User\PasswordController@getReset');
Route::post('/reset', 'SidneyDobber\User\PasswordController@postReset');


/*
|--------------------------------------------------------------------------
| Foobar.
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(["middleware" => "auth"], function() {

    // Users route..
    Route::get("/admin/users", "SidneyDobber\User\UserController@users");

    // Add user routes.
    Route::get("/admin/users/add", "SidneyDobber\User\UserController@addUser");
    Route::post("/admin/users/add", "SidneyDobber\User\UserController@addUser");

    // View and edit user routes.
    Route::get("/admin/users/{user}", "SidneyDobber\User\UserController@user");
    Route::post("/admin/users/{user}", "SidneyDobber\User\UserController@user");

    // Delete user route.
    Route::get("/admin/users/{user}/delete", "SidneyDobber\User\UserController@deleteUser");

    // Logout route.
    Route::get('/logout', 'SidneyDobber\User\AuthController@getLogout');

    // Admin dashboard route.
    Route::get("/admin/dashboard", "SidneyDobber\User\AuthController@dashboard");

});