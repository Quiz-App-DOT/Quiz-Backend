<?php

namespace App\Services;

interface AuthService
{
    public function login($username, $pass);
    public function signup($user);
    public function logout();
    public function validateUser($username, $pass);
}