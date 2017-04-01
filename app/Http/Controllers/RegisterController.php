<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{
    public function register(Request $request){
      $this->validate($request, [
        'username' => 'required|max:255|unique:users',
        'phonenumber' => 'required|max:255|unique:users',
        'password' => 'required|max:255',
      ]);

      $api_token = str_random(60);

      $data = $request->only(['username','password','phonenumber']);
      $data['api_token'] = $api_token;
      $data['password'] = Hash::make( $data['password'] );
      $user = User::create($data);

      return response()->json([
        'status' => 'ok',
        'token' => $api_token
      ]);
    }
}
