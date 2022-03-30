<?php

namespace App;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = 'menus';
    protected $fillable = ['name', 'price', 'actual_cost', 'crust', 'size', 'addons', 'description', 'cate_id', 'rstrt_slug', 'photo', 'status', 'dining_service', 'takeaway_service', 'menu_tag'];
    
    public function menuCategory()
    {
    	return $this->belongsTo('App\Category', 'cate_id', 'id');
    }

    public function stockAmount(){
        return $this->hasOne(Stock::class, 'menu_id');
    }
}
