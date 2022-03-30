<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    // use HasFactory;

    public function cateInfo(){
        return $this->belongsTo(StockCat::class, 'CateId', 'CateId');
    }
    
    public function brandInfo(){
        return $this->belongsTo(Brand::class, 'BranId', 'BranId');
    }
}

// Bit bucket
// Email address
// nuttertools152080@gmail.com
// Full name
// Arman Mahmud


// github
// name
// arman1804
