<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;

class TenantController extends Controller
{
    public function update_profile(Request $request){
      $this->validate($request,[
        'description' => 'required|max:255',
        'tenant_name' => 'required|max:255'
      ]);

      $tenant = $request->user()->tenant();
      if( $tenant->count() == 0 ){
        $tenant = Tenant::create([
          'user_id' => $request->user()->id,
          'description' => 'No Description Yet',
          'tenant_name' => 'Tenant Anonymous'
        ]);
      }

      $tenant->update($request->only([
        'description', 'tenant_name'
      ]));

      return $tenant;
    }

    public function profile(Request $request){
      $tenant = $request->user()->tenant();
      if( $tenant->count() == 0 ){
        $tenant = Tenant::create([
          'user_id' => $request->user()->id,
          'description' => 'No Description Yet',
          'tenant_name' => 'Tenant Anonymous'
        ]);
      }

      return $tenant;
    }
}
