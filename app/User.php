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
        'password', 'remember_token',
    ];

    public function role_str(){
      if( $this->role == 0 )
        return "user";
      else if( $this->role == 1 )
        return "tenant";
    }

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
}
