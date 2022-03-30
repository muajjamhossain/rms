<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['address', 'user_id', 'rstrt_slug'];

    public function userInfo()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function restaurantInfo()
    {
    	return $this->belongsTo('App\Restaurant', 'rstrt_slug', 'slug');
    }
}
