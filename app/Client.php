<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'name','email','phone','company_name','address','subs_finishing_date','photo','package_id','status', 'package_at'
    ];
    public function scopePublished($query)
    {
    	return $query->where('status',1);
    }
    public function restaurantInfo() 
	{
	  return $this->hasMany('App\Restaurant', 'client_id', 'id');
	}
    public function packageInfo()
    {
        return $this->belongsTo('App\Package', 'package_id', 'id');
    }
    public function paymentInfo()
    {
        return $this->hasMany('App\Payment', 'client_id', 'id');
    }
}
