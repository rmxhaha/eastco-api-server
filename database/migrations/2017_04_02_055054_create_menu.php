<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('menus', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description');
          $table->string('picture')->nullable();
          $table->integer('price')->default(0);
          $table->unsignedInteger('tenant_id');
          $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
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
      Schema::dropIfExists('menus');
    }
}
