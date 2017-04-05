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
    Route::group(['prefix' => 'menu'], function(){
      Route::get('/', 'MenuController@all_tenant');
      Route::get('/{tenant_id}/', 'MenuController@tenant_menu')->where('tenant_id', '[0-9]+');;
    });

    Route::group(['prefix' => 'tenant','middleware'=>'tenant'], function() {
      Route::get('/profile', 'TenantController@profile');
      Route::post('/profile', 'TenantController@update_profile');

      Route::get('/menu', 'TenantController@all_menu');
      Route::post('/menu', 'TenantController@new_menu');

      Route::group(['middleware'=>'mymenu'], function(){
        Route::post('/menu/{menu_id}', 'TenantController@update_menu');
        Route::delete('/menu/{menu_id}', 'TenantController@delete_menu');
      });

    });
  });

  Route::post('/login', 'LoginController@login');
  Route::post('/register', 'RegisterController@register');
});
