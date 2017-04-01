<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    //
    public function login(Request $request){
      $this->validate($request, [
        'username' => 'required|max:255',
        'password' => 'required|max:255',
      ]);

      $user = User::where('username', $request->username)->first();

      if( $user && Hash::check( $request->password, $user->password ) ){

        $api_token = str_random(60);

        $user->api_token = $api_token;
        $user->save();

        return response()->json([
          'status' => 'ok',
          'token' => $api_token
        ]);
      }
      else {
        return response()->json([
          'username' => 'wrong credential',
          'password' => 'wrong credential'
        ], 422);
      }



    }
}
