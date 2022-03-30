<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_details";
    protected $fillable = ['order_id', 'menu_id', 'qty'];

    public function orderDetailMenu($value='')
    {
    	return $this->hasOne('App\Menu', 'id', 'menu_id');
    }
}
