<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantOrderController extends Controller
{
    //
    public function ongoing(Request $request){
      return response()->json([
        'transactions' => $request->user()->tenant->ongoing_orders
      ]);
    }

    public function history(Request $request){
      return response()->json([
        'transactions' => $request->user()->tenant->finished_orders
      ]);
    }

    public function accept_order(){

    }

    public function deny_order(){

    }

    public function cancel_order(){

    }
}
