<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'description','cover_picture', 'tenant_name', 'user_id'
    ];
    protected $hidden = [
        'updated_at', 'created_at','user_id'
    ];

    public function user(){
      return $this->hasOne('App\User','user_id','id');
    }

    public function menus(){
      return $this->hasMany('App\Menu');
    }

    public function orders(){
      return $this->hasMany('App\Order','tenant_id','id');
    }
}
