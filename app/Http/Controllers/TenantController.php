<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Menu;

class TenantController extends Controller
{
    public function update_profile(Request $request){
      $this->validate($request,[
        'description' => 'required|max:255',
        'tenant_name' => 'required|max:255'
      ]);
      $tenant = $request->user()->tenant;

      $tenant->update($request->only([
        'description', 'tenant_name'
      ]));

      return response()->json($tenant);
    }

    public function profile(Request $request){
      $tenant = $request->user()->tenant;

      return response()->json($tenant);
    }

    public function all_menu(Request $request){
      $menus = $request->user()->tenant->menus;
      return response()->json([
        'menus' => $menus
      ]);

    }
    public function new_menu(Request $request){
      $tenant_id = $request->user()->tenant->id;
      $this->validate($request,[
        'name' => 'max:255|required',
        'description' => 'max:255|required',
        'price' => 'integer|required',
        'picture' => 'file|image|max:4096'
      ]);
      if( $request->picture )
        $path = $request->picture->store('menu_picture');
      else {
        $path = NULL;
      }

      $menu_data = collect($request->only([
        'name', 'description', 'price'
      ]))->merge([
        'tenant_id' => $tenant_id,
        'picture' => $path
      ])->all();

      $menu = Menu::create($menu_data);

      return response()->json([
        'status' => 'ok'
      ]);
    }
    public function delete_menu(Request $request, $menu_id){
      \Validator::make(['menu_id'=>$menu_id],[
        'menu_id' => 'required|integer|exists:menus,id'
      ])->validate();

      $menu = Menu::find($request->menu_id);
      $tenant = $request->user()->tenant;

      if( $menu->tenant_id != $tenant->id )
        return response()->json([
          'status' => 'fail',
          'message' => 'This is not your menu'
        ]);

      $menu->delete();
      return response()->json([
        'status' => 'ok',
        'message' => 'Menu deleted'
      ]);
    }
}
