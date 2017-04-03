<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;

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

      return response()->json($tenant->menu);
    }
}
