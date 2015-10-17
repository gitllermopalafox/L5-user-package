<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Superuser.
	|--------------------------------------------------------------------------
	|
	| The superuser is the only userrole that shouldn't be changed since
	| it is a reserved role that has access to every functionality in
	| an application.
	|
	*/

	'superuser' => 0,

	/*
	|--------------------------------------------------------------------------
	| Admin.
	|--------------------------------------------------------------------------
	|
	| An admin should have less permissions then the superuser. The difference
	| between a superuser and an admin should be in regarding making changes
	| to the system for example changing system settings. The admin can be
	| changed and is not reserved.
	|
	*/

	'admin' => 1,

	/*
	|--------------------------------------------------------------------------
	| Author.
	|--------------------------------------------------------------------------
	|
	| An author in the default hierarchy has the least permissions. In the
	| sample pages the author can only view the dashboard and edit it's own
	| emailaddress.
	|
	*/

	'author' => 2,

);