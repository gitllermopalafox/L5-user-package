<?php

namespace SidneyDobber\User;

interface UserRepositoryInterface {

    public function readAll();
    public function read($id);
    public function delete($id);
    public function create();
    public function update($user);
    public function reset();
    public function request();
    public function login();

}
