<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAndDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('addresses', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->timestamps();
      });

      Schema::create('orders', function (Blueprint $table) {
          $table->increments('id');
          $table->string('address_description')->nullable();
          $table->unsignedInteger('address_id')->nullable();
          $table->unsignedInteger('total_price')->default(0);
          $table->unsignedInteger('status')->default(100);

          $table->unsignedInteger('tenant_id')->nullable(); // seller
          $table->unsignedInteger('orderer_id')->nullable(); // buyer
          $table->foreign('tenant_id')->references('id')->on('tenants');
          $table->foreign('orderer_id')->references('id')->on('users');
          $table->foreign('address_id')->references('id')->on('addresses');
          $table->timestamps();
      });

      Schema::create('order_details', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('order_id');
          $table->unsignedInteger('menu_id');
          $table->unsignedInteger('menu_price');
          $table->unsignedInteger('amount');
          $table->string('description')->default("-");
          $table->foreign('order_id')->references('id')->on('orders');
          $table->foreign('menu_id')->references('id')->on('menus');
          $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('order_details');
      Schema::dropIfExists('orders');
      Schema::dropIfExists('addresses');
    }
}
