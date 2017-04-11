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
    Route::get('/addresses', 'AddressController@get_all');
    Route::post('/user', function (Request $request) {
        return $request->user()->tenant()->count();
    });

    // user order use case
    Route::group(['prefix'=>'order'], function(){
      Route::get('/history','UserOrderController@get_history');
      Route::get('/ongoing','UserOrderController@get_ongoing');
      Route::get('/cart','UserOrderController@get_cart');
      Route::post('/add_to_cart','UserOrderController@add_to_cart');
      Route::post('/checkout','UserOrderController@checkout');
    });

    // viewing menu use case
    Route::group(['prefix' => 'menu'], function(){
      Route::get('/', 'MenuController@all_tenant');
      Route::get('/{tenant_id}/', 'MenuController@tenant_menu')->where('tenant_id', '[0-9]+');
    });

    // tenant use case
    Route::group(['prefix' => 'tenant','middleware'=>'tenant'], function() {
      Route::get('/profile', 'TenantController@profile');
      Route::post('/profile', 'TenantController@update_profile');

      Route::get('/menu', 'TenantController@all_menu');
      Route::post('/menu', 'TenantController@new_menu');

      Route::group(['middleware'=>'mymenu'], function(){
        Route::post('/menu/{menu_id}', 'TenantController@update_menu');
        Route::delete('/menu/{menu_id}', 'TenantController@delete_menu');
      });

      Route::group(['prefix'=>'order'], function(){
        Route::get('/history', 'TenantOrderController@history');
        Route::get('/ongoing', 'TenantOrderController@ongoing');
        Route::group(['middleware'=>'myorder'], function(){
          Route::post('/ongoing/{order_id}/accept/', 'TenantOrderController@accept_order');
          Route::post('/ongoing/{order_id}/deny/', 'TenantOrderController@deny_order');
          Route::post('/ongoing/{order_id}/cancel/', 'TenantOrderController@cancel_order'); // ? in case di butuhkan cancel manual
          Route::post('/ongoing/{order_id}/ready_to_deliver/', 'TenantOrderController@ready_to_deliver'); // ? in case di butuhkan cancel manual
        });
      });

    });
  });

  Route::get('/menu_picture/{menu_id}/', 'MenuController@menu_picture')->where('menu_id', '[0-9]+');
  Route::get('/tenant_picture/{tenant_id}/', 'MenuController@menu_picture')->where('tenant_id', '[0-9]+');

  Route::post('/login', 'LoginController@login');
  Route::post('/register', 'RegisterController@register');
});
