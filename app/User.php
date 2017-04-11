<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','api_token', 'phonenumber', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at','created_at','api_token'
    ];

    public function getRoleAttribute($value){
      if( $value == 0 )
        return "user";
      else if($value == 1 )
        return "tenant";
      else {
        return "unknown";
      }
    }

    public function setRoleAttribute($value){
      if( $value == "user" )
        $this->attributes['role'] = 0;
      else if($value == "tenant")
        $this->attributes['role'] = 1;
      else {
        $this->attributes['role'] = -1;
      }
    }

    public function tenant(){
      return $this->belongsTo('App\Tenant','id','user_id');
    }

    public function orders(){
      return $this->hasMany('App\Order','orderer_id','id');
    }

    public function finished_orders(){
      return $this->orders()->whereIn('status', [800, 900]);
    }

    public function cart(){
      return $this->orders()->whereIn('status', [100])->first();
    }

    public function ongoing_orders(){
      return $this->orders()->whereIn('status', [200, 201, 300]);
    }
}
