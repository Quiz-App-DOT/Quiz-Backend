<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthController extends Controller
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        JWTAuth::factory()->setTTL(30);
    }

    public function login(Request $request) {
        try {
            $response = $this->authService->login($request['username'], $request['password']);

            return response($response, $response['status'] ?? 200);
        } catch (Error $err) {
            return response(['Message' => 'Internal Server Error'], 500);
        }
    }

    public function signup(Request $request) {
        try {
            $response = $this->authService->signup($request);

            return response($response, $response['status'] ?? 200);
        } catch (Error $err) {
            return response(['Message' => 'Internal Server Error'], 500);
        }

        return response($response, 200);
    }

    public function logout() {
        auth()->logout();

        return response(['message' => 'Successfully logged out'], 200);
    }

    public function refresh() {
        return response(Auth::refresh(), 200);
    }
}
