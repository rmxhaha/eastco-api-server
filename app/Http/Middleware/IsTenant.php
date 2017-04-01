<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsTenant
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
      if (Auth::user() && Auth::user()->role == 'tenant') {
        return $next($request);
      }

     return response()->json([
       'status' => 'fail',
       'message' => 'You are not a tenant'
     ],422);
    }
}
