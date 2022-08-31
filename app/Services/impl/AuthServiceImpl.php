<?php

namespace App\Services\impl;

use App\Models\User;
use App\Services\AuthService;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthServiceImpl implements AuthService
{

    public function validateUser($username, $pass) {
        $credentials = ['username' => $username, 'password' => $pass];
        $token = Auth::attempt($credentials);
        
        return $token;
    }

    public function login($username, $pass) {
        try {
            $validator = Validator::make(['username' => $username, 'password' => $pass], [
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:6'
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
            
            $userValid = $this->validateUser($username, $pass);
            
            // userValid is a token if user is valid
            if ($userValid) {
                $response['user'] = Auth::user();
                $response['authorization'] = ['token' => $userValid, 'type' => 'bearer'];
                
                return $response;
            }

            return (['Message' => "Unauthenticated", 'status' => 401]);
        } catch (Error $err) {
            return $err;
        }
    }

    public function signup($user) {
        try {
            $validator = Validator::make($user->all(), [
                'fullName' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
    
            $pass = $user['password'];
            $user['password'] = Hash::make($user['password']);
            $user = User::create($user->toArray());
    
            $token = $this->validateUser($user['username'], $pass);
    
            $response['user'] = $user;
            $response['authorisation'] = ['token' => $token, 'type' => 'bearer'];

            return $response;
        } catch (Error $err) {
            return $err;
        }
    }

    public function logout() {

    }
}