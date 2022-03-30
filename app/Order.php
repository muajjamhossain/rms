<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
	use Notifiable;

	protected $table = 'orders';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'avg_time', 'phone', 'email', 'rstrt_slug','slug', 'table_no', 'delivery_date', 'delivery_time', 'total_amount', 'details', 'payment_status','updated_bye', 'cancel_status', 'status', 'type'];

	public function orderRestaurant()
	{
		return $this->belongsTo('App\Restaurant','rstrt_slug','slug');
	}

	public function detailInfo()
	{
		return $this->hasMany('App\OrderDetail', 'order_id');
	}

	public function userInfo()
	{
		return $this->belongsTo('App\User','updated_by', 'id');
	}

	public function billInfo()
	{
		return $this->belongsTo('App\Bill','slug','order_slug');
	}
}
