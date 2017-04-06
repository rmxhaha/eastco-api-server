<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['address_description','address_id','total_price','tenant_id','orderer_id','status'];
    protected $hidden = ['created_at','updated_at'];

    private static $status_str_map = [
      100 => "ordering",
      200 => "waiting_for_response",
      201 => "processing",
      300 => "delivering",
      800 => "finished",
      900 => "canceled",
      1000 => "unknown"
    ];

    public function orderer(){
      return $this->belongsTo('App\User','orderer_id','id');
    }

    public function tenant(){
      return $this->belongsTo('App\Tenant','id','tenant_id');
    }

    public function details(){
      return $this->hasMany('App\OrderDetail');
    }

    public function address(){
      return $this->hasOne('App\Address','id','address_id');
    }


    public function setStatusAttribute($value){
      $status_map = collect( self::$status_str_map)->flip()->all();
      if( !array_key_exists($value, $status_map) )
        return "unknown";
      else
        $this->attributes['status'] = $status_map[$value];
    }

    public function getStatusAttribute($value){
      if( !array_key_exists($value, self::$status_str_map) )
        return 1000;
      else
        return self::$status_str_map[$value];
    }
}
