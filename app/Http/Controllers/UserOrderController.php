<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Address;
use App\Menu;

class UserOrderController extends Controller
{
    //
    public function get_history(Request $request){
      return response()->json([
        'transactions' => $request->user()->finished_orders
      ]);
    }

    public function get_ongoing(Request $request){
      return response()->json([
        'transactions' => $request->user()->ongoing_orders
      ]);
    }

    public function get_cart(Request $request){
      $cart = $request->user()->cart();

      if( $cart == null )
        $cart = Order::create(['orderer_id'=>$request->user()->id, 'status'=> "ordering"]);

      return response()->json([
        'items' => $cart->details
      ]);
    }

    public function add_to_cart(Request $request){
      $cart = $request->user()->cart();

      if( $cart == null )
        $cart = Order::create(['orderer_id'=>$request->user()->id, 'status'=> "ordering"]);

      $this->validate($request, [
        "menu_id" => "required|integer|exists:menus,id|min:0",
        "amount" => "required|integer|min:1",
        "description" => "max:255"
      ]);

      $cart_id = $cart->id;
      $menu = Menu::find($request->menu_id);

      if( $cart->tenant_id != null && $cart->tenant_id != $menu->tenant_id )
        return response()->json([
          'status'=>'fail',
          'message'=>'You may not order from more than 1 tenant at a time'
        ],422);

      if( $cart->tenant_id == null )
        $cart->update(['tenant_id'=>$menu->tenant_id]);

      if( empty( $request->description ) )
        $request->description = "-";

      $order_detail = OrderDetail::create([
        'order_id' => $cart->id,
        'amount' => $request->amount,
        'description' => $request->description,
        'menu_price' => $menu->price,
        'menu_id' => $menu->id,
      ]);

      return response()->json([
        'status'=> 'ok',
        'message'=> 'item added to cart'
      ]);
    }

    public function checkout(Request $request){
      $this->validate($request,[
        'address_description' => 'max:255',
        'address_id' => 'required|integer|min:0|exists:addresses,id',
      ]);

      $cart = $request->user()->cart();

      if( $cart == null || $cart->details()->count() == 0 )
        return response()->json([
          'status'=>'fail',
          'message'=>'You haven\'t added anything to your cart'
        ],422);

      $total_price = collect( $cart->details )->map(function($detail){
        return $detail->menu_price * $detail->amount;
      })->reduce(function($carry, $item){
        return $carry + $item;
      },0);

      $checkout_data = collect([
        'status'=>'waiting_for_response',
        'total_price'=>$total_price,
        'address_description'=>$request->address_description,
        'address_id'=>$request->address_id
      ])->reject(function($value,$key){
        return ( $value == null );
      })->all();

      $cart->update($checkout_data);
      return response()->json([
        'status'=>'ok',
        'message'=>'Wait for your tenant respond'
      ]);
    }
}
