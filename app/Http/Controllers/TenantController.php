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
}
