<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Menu;
use Storage;

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

    private function get_menu_data_from_request(Request $request){
      if( $request->picture != NULL )
        $path = $request->picture->store('menu_picture');
      else {
        $path = NULL;
      }

      $tenant_id = $request->user()->tenant->id;
      $menu_data = collect($request->only([
        'name', 'description', 'price'
      ]))->merge([
        'tenant_id' => $tenant_id,
        'picture' => $path
      ])->all();

      return $menu_data;
    }

    public function new_menu(Request $request){
      $this->validate($request,[
        'name' => 'max:255|required',
        'description' => 'max:255|required',
        'price' => 'integer|required',
        'picture' => 'file|image|max:4096'
      ]);

      $menu_data = $this->get_menu_data_from_request($request);
      $menu = Menu::create($menu_data);

      return response()->json([
        'status' => 'ok',
        'message' => 'Menu created'
      ]);
    }
    public function delete_menu(Request $request, $menu_id){ // routes is already secured by IsMyMenu
      $menu = Menu::find($menu_id);

      $menu->delete();
      return response()->json([
        'status' => 'ok',
        'message' => 'Menu deleted'
      ]);
    }

    public function update_menu(Request $request, $menu_id){ // routes is already secured by IsMyMenu
      $this->validate($request,[
        'name' => 'max:255',
        'description' => 'max:255',
        'price' => 'integer',
        'picture' => 'file|image|max:4096'
      ]);

      $menu = Menu::where('id', $menu_id);
      $rmenu = $menu->first();
      if( $request->picture != NULL && $rmenu->picture != NULL )
        Storage::delete($rmenu->picture);

      $menu_data = $this->get_menu_data_from_request($request);
      $menu_data = array_filter($menu_data, function($value){
  			return ($value !== null);
  		});


      $menu->update($menu_data);

      return response()->json([
        'status' => 'ok',
        'message' => 'Menu updated'
      ]);
    }
}
