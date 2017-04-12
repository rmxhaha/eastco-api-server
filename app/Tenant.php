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

    public function ongoing_orders(){
      return $this->orders()->whereIn('status', [200, 201, 300])->with('orderer')->with('details')->with('address')->with('details.menu');
    }

    public function finished_orders(){
      return $this->orders()->whereIn('status', [800, 900])->with('orderer')->with('details')->with('address')->with('details.menu');
    }

    public function getCoverPictureAttribute($value){
      if( $value == null ) return null;
      return action('MenuController@tenant_picture', ['tenant_id' => $this->id ]);
    }

    public function getCoverPicturePath(){
      return $this->attributes['cover_picture'];
    }
}
