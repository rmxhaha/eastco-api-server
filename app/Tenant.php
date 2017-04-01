<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'description','cover_picture', 'tenant_name', 'user_id'
    ];

    public function user(){
      return $this->hasOne('App\User');
    }
}
