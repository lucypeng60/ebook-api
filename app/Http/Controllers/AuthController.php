<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function me() {
    return ['NIS' => 3103119102,
        'name' => 'Lucy Aprilianda Putri Peng',
        'gender' => 'Female',
        'phone' => '08980600403',
        'class' => 'XII RPL 3'];
  }
  
  public function register(Request $request){

    $input = $request->all();

    $validator = Validator::make(
        $input,
        [
            'name' => 'required',
            'email' => 'required |email | unique:users,email',
            'password' => 'required | confirmed | min:6',
        ]
    );

    if ($validator ->fails()) {
        return response()->json($validator->errors(),400);

    }

    $input['password'] = Hash::make($input['password']);

    $user = User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => $input['password'],
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
       'access_token' => $token,
       'token_type' => 'Bearer',
    ],201);

}

public function login(Request $request){
    $input = $request->all();

    $validator = Validator::make(
        $input,
        [
            'email' => 'required',
            'password' => 'required',
        ]
    );

    if ($validator ->fails()) {
        return response()->json($validator->errors(),400);

    }

    $user = User::where('email', $input['email'])->firstOrFail();

    if (Hash::check($input['password'],$user['password'])) {
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
        ],202);
    }
    return response()->json('Email or Password is incorrect', 401);

}
public function logout(Request $request){
    $request->user()->tokens()->delete();
    return response()->json([
        'mesage' => 'logout',
        200
    ]);
}
}
