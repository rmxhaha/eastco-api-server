<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;

class IsMyOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $order_id = $request->order_id;
      \Validator::make(['order_id'=>$order_id],[
        'order_id' => 'required|integer'
      ])->validate();

      $order = Order::findOrFail($order_id);
      $tenant = $request->user()->tenant;

      $request->order = $order;

      if( $order->tenant_id != $tenant->id )
        return response()->json([
          'status' => 'fail',
          'message' => 'This is not your order'
        ]);

      return $next($request);
    }
}
