<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthController extends Controller
{
    public function __construct()
    {
        JWTAuth::factory()->setTTL(30);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);
        
        $credentials = request(['username', 'password']);
        $token = Auth::attempt($credentials);
        if ($token) {
            $response['user'] = Auth::user();
            $response['status'] = 'Success';
            $response['authorisation'] = ['token' => $token, 'type' => 'bearer'];

            return response($response, 200);
        }
        
        return response(['status' => '401', 'message' => 'Unauthorized'], 401);
    }

    public function signup(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);

        $pass = $request['password'];
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());

        $credentials = ['username' => $request['username'], 'password' => $pass];
        $token = Auth::attempt($credentials);

        $response['user'] = $user;
        $response['status'] = 'Success';
        $response['authorisation'] = ['token' => $token, 'type' => 'bearer'];

        return response($response, 200);
    }
}
