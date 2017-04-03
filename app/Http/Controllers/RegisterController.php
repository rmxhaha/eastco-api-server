<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Tenant;

class RegisterController extends Controller
{
    public function register(Request $request){
      $this->validate($request, [
        'username' => 'required|max:255|unique:users',
        'phonenumber' => 'required|max:255|unique:users',
        'password' => 'required|max:255',
        'role' => 'required|in:tenant,user'
      ]);

      $api_token = str_random(60);

      $data = $request->only(['username','password','phonenumber','role']);
      $data['api_token'] = $api_token;
      $data['password'] = Hash::make( $data['password'] );
      $user = User::create($data);

      if( $user->role == "tenant" ){
        $tenant = Tenant::create([
          'user_id' => $user->id,
          'description' => 'No Description Yet',
          'tenant_name' => 'Tenant Anonymous'
        ]);
      }

      return response()->json([
        'status' => 'ok',
        'token' => $api_token
      ]);
    }
}
