<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {
  Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/user', function (Request $request) {
        return $request->user()->tenant()->count();
    });
    Route::group(['prefix' => 'tenant','middleware'=>'tenant'], function() {
      Route::post('/profile', 'TenantController@profile');
      Route::post('/update-profile', 'TenantController@update_profile');
    });
  });

  Route::post('/login', 'LoginController@login');
  Route::post('/register', 'RegisterController@register');
});
