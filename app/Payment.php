<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function packageInfo()
    {
    	return $this->belongsTo('App\Package', 'package_id', 'id');
    }
}
