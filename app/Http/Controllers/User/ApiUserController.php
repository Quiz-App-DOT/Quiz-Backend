<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    public function getOneUserByToken() {
        $user = User::where('id', auth()->user()['id'])->first();

        return response($user, 200);
    }

    public function updateOneUserByToken(Request $request) {
        $validator = Validator::make($request->all(), [
            auth()->id() => 'exists:users,id',
            'fullName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.auth()->user()['id'],
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()['id'],
            'password' => 'string|min:6',
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);
    
        $user = User::where('id', auth()->user()['id'])->first();
        $user['fullName'] = $request['fullName'];
        $user['username'] = $request['username'];
        $user['email'] = $request['email'];
        $user['password'] = $request['password'] ? $request['password'] : $user['password'];

        $user->save();

        return response($user, 200);
    }
}
