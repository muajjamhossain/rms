<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use SoftDeletes;

    protected $table = 'restaurants';

    protected $fillable = [
        'name','client_id','phone','url','address','logo', 'menu_image_display', 'menu_heading', 'menu_categorised', 'takeaway_switch', 'status', 'slug'
    ];
    
    public function scopePublished($query)
    {
    	return $query->where('status',1);
    }
    // Relations
    public function clientInfo()
    {
    	return $this->belongsTo('App\Client', 'client_id', 'id');
    }
    public function categoryInfo()
    {
        return $this->hasMany('App\Category', 'rstrt_slug', 'slug');
    }
    public function menuInfo()
    {
        return $this->hasMany('App\Menu', 'rstrt_slug', 'slug');
    }
    public function orderInfo()
    {
        return $this->hasMany('App\Order', 'rstrt_slug', 'slug');
    }
    public function employeeInfo()
    {
        return $this->hasMany('App\Employee', 'rstrt_slug', 'slug');
    }
}
