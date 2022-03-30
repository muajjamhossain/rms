<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['order_slug', 'rstrt_slug', 'discount', 'amount', 'pay_by', 'given_amount'];

    public function orderInfo()
    {
    	return $this->belongsTo('App\Order', 'order_slug', 'slug');
    }
    
}
