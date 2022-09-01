<?php

namespace App\Services;

interface UserService
{
    public function getOneUserByToken($token);
    public function getOneUserById($id);
    public function updateOneUserByToken($data);
}