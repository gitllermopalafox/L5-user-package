<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| From address.
	|--------------------------------------------------------------------------
	|
	| ...
	|
	*/

	'from_address' => 'noreply@example.com',

	/*
	|--------------------------------------------------------------------------
	| New User E-Mail Template
	|--------------------------------------------------------------------------
	|
	| This is the template that is used to render the the email that is 
	| send to a newly created user. By default the template from the Atom End
	| User package will be used.
	|
	*/

	'new_user' => 'user::emails.new-user',

	/*
	|--------------------------------------------------------------------------
	| New User Subject.
	|--------------------------------------------------------------------------
	|
	| ...
	|
	*/

	'new_user_subject' => 'Your new account',

	/*
	|--------------------------------------------------------------------------
	| Reset Password E-Mail Template
	|--------------------------------------------------------------------------
	|
	| This is the template that is used to render the the email that is 
	| send to an existing user for reseting his or her password. By default
	| the template from the Atom End User package will be used.
	|
	*/

	'reset_password' => 'user::emails.reset-password',

	/*
	|--------------------------------------------------------------------------
	| Reset Password Subject.
	|--------------------------------------------------------------------------
	|
	| ...
	|
	*/

	'reset_password_subject' => 'Reset password',

);