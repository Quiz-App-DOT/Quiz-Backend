<?php

namespace App\Services\impl;

use App\Models\User;
use App\Services\UserService;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserServiceImpl implements UserService
{
    public function getOneUserByToken($token) {
        try {
            $user = User::where('id', auth()->user()['id'])->first();

            return $user;
        } catch (Error $err) {
            return $err;
        }
    }

    public function getOneUserById($id) {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'exists:users,id',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
    
            $user = User::where('id', $id)->first();

            return $user;
        } catch (Error $err) {
            return $err;
        }
    }

    public function updateOneUserByToken($data) {
        try {
            $validator = Validator::make($data->all(), [
                auth()->id() => 'exists:users,id',
                'fullName' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,'.auth()->user()['id'],
                'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()['id'],
                'password' => 'string|min:6',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
    
            $user = User::where('id', auth()->user()['id'])->first();
            $user['fullName'] = $data['fullName'];
            $user['username'] = $data['username'];
            $user['email'] = $data['email'];
            $user['password'] = $data['password'] ? $data['password'] : $user['password'];
    
            $user->save();
        
            return $user;
        } catch (Error $err) {
            return $err;
        }
    }
}