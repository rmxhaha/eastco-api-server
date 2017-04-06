<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = ['name'];
    protected $hidden = ['created_at','updated_at'];
    protected $table = "addresses";

    public function order(){
      $this->belongsToMany('App\Order','address_id','id');
    }
}
