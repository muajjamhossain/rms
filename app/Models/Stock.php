<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // use HasFactory;

    protected $table = 'stocks';
    // protected $fillable = ['rstrt_slug'];
    protected $guarded = [];
    
    public function cateInfo(){
        return $this->belongsTo(StockCat::class, 'CateId', 'CateId');
    }

    public function brandInfo(){
        return $this->belongsTo(Brand::class, 'BranId', 'BranId');
    }

    public function sizeInfo(){
        return $this->belongsTo(Size::class, 'SizeId', 'SizeId');
    }

    public function thickInfo(){
        return $this->belongsTo(Thickness::class, 'ThicId', 'ThicId');
    }
}
