<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $fillable = [
      'name','description', 'price','picture', 'tenant_id'
  ];

  protected $hidden = [
      'updated_at', 'created_at','tenant_id'
  ];

  public function tenant(){
    return $this->belongsTo('App\Tenant');
  }
}
