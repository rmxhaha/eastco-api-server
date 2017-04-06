<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['address','total_cost','tenant_id','orderer_id'];
    protected $hidden = ['created_at','updated_at'];

    public function orderer(){
      return $this->belongsTo('App\User','id','orderer_id');
    }

    public function tenant(){
      return $this->belongsTo('App\Tenant','id','tenant_id');
    }

    public function details(){
      return $this->hasMany('App\OrderDetail');
    }
}
