<?php

namespace App\Http\Middleware;

use Closure;
use App\Menu;

class IsMyMenu
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
      $menu_id = $request->menu_id;
      \Validator::make(['menu_id'=>$menu_id],[
        'menu_id' => 'required|integer'
      ])->validate();

      $menu = Menu::findOrFail($menu_id);
      $tenant = $request->user()->tenant;

      if( $menu->tenant_id != $tenant->id )
        return response()->json([
          'status' => 'fail',
          'message' => 'This is not your menu'
        ]);

      return $next($request);
    }
}
