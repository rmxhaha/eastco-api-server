<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $fillable = ['order_id','amount','menu_price','description'];
    protected $hidden = ['created_at','updated_at'];

    public function order(){
      return $this->belongsTo('App\Order');
    }
}
