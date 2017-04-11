<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $fillable = ['order_id','amount','menu_price','description','menu_id'];
    protected $hidden = ['created_at','updated_at','order_id'];
    protected $table = "order_details";

    public function order(){
      return $this->belongsTo('App\Order');
    }

    public function menu(){
      return $this->belongsTo('App\Menu','menu_id','id');
    }
}
