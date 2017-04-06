<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;

class UserOrderController extends Controller
{
    //
    public function get_history(Request $request){
      return response()->json([
        'transactions' => $request->user()->finished_transactions
      ]);
    }

    public function get_ongoing(Request $request){
      return response()->json([
        'transactions' => $request->user()->ongoing_transactions
      ]);
    }

    public function new_transaction(Request $request){
      $order_data = [];
      $order = Order::create($order_data);

    }
}
