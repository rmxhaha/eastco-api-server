<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
    //
    public function get_all(){
      return response()->json([
        'addresses' => Address::all()
      ]);
    }
}
