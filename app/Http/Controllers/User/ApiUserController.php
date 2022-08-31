<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function getOneUserByToken() {
        try {
            $user = $this->userService->getOneUserByToken(auth()->user()['id']);

            return response($user, 200);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }

        return response($user, 200);
    }

    public function getOneUserById($id) {
        try {
            $user = $this->userService->getOneUserById($id);
            
            return response($user, $user['status'] ?? 200);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }
    }

    public function updateOneUserByToken(Request $request) {
        try {
            $user = $this->userService->updateOneUserByToken($request);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }
    }
}
