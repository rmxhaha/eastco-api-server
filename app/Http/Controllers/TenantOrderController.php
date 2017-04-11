<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantOrderController extends Controller
{
    //
    public function ongoing(Request $request){
      $transactions = $request->user()->tenant->ongoing_orders;
      foreach($transactions as $trans){
        $trans->orderer();
        $trans->details();
      }
      return response()->json([
        'transactions' => $transactions
      ]);
    }

    public function history(Request $request){
      return response()->json([
        'transactions' => $request->user()->tenant->finished_orders
      ]);
    }

    public function accept_order(Request $request){
      $order = $request->order; // in middleware IsMyOrder
      if( $order->status != "waiting_for_response" )
        return response()->json([
          'status' => 'fail',
          'message' => 'Your action is invalid please restart application'
        ], 422);

      $order->update(['status'=>'processing']);

      return response()->json(['status' => 'ok', 'message'=> 'successfully accapted']);
    }

    public function deny_order(Request $request){
      $order = $request->order; // in middleware IsMyOrder
      if( $order->status != "waiting_for_response" )
        return response()->json([
          'status' => 'fail',
          'message' => 'Your action is invalid please restart application'
        ], 422);

      $order->update(['status'=>'canceled']);

      return response()->json(['status' => 'ok', 'message'=> 'successfully denied']);
    }

    public function cancel_order(Request $request){
      $order = $request->order; // in middleware IsMyOrder
      if( $order->status != "processing" )
        return response()->json([
          'status' => 'fail',
          'message' => 'Your action is invalid please restart application'
        ], 422);

      $order->update(['status'=>'canceled']);
      return response()->json(['status' => 'ok', 'message'=> 'successfully canceled']);
    }

    public function ready_to_deliver(Request $request){
      $order = $request->order; // in middleware IsMyOrder
      if( $order->status != "processing" )
        return response()->json([
          'status' => 'fail',
          'message' => 'Your action is invalid please restart application'
        ], 422);

      $order->update(['status'=>'delivering']);
      return response()->json(['status' => 'ok', 'message'=> 'Ready to Deliver']);
    }
}
