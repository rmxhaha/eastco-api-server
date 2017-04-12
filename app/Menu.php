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

  public function getPictureAttribute($value){
    if( $value == null ) return null;
    return action('MenuController@menu_picture', ['menu_id' => $this->id ]);
  }

  public function getPicturePath(){
    return $this->attributes['picture'];
  }
}
