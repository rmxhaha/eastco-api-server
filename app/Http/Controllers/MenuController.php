<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Menu;

class MenuController extends Controller
{
    public function all_tenant(){
      $tenants = Tenant::all();
      return response()->json($tenants);
    }

    public function tenant_menu(Request $request, $tenant_id){
      $tenant = Tenant::where('id',$tenant_id);
      if( $tenant->count() == 0 )
        return response()->json([
          'status' => 'fail',
          'message' => 'Your tenant doesn\'t exist'
        ]);

      $tenant = $tenant->first();

      return response()->json([
        'menus' => $tenant->menus
      ]);
    }

    public function menu_picture(Request $request, $menu_id){
      $menu = Menu::findOrFail($menu_id);
      return response()->file( storage_path('app/'.$menu->getPicturePath()) );
    }

    public function tenant_picture(Request $request, $tenant_id){
      $menu = Tenant::findOrFail($tenant_id);
      return response()->file( storage_path('app/'.$tenant->getCoverPicturePath()) );
    }
}
