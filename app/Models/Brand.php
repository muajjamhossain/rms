<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // use HasFactory;

    public function cateInfo(){
        return $this->belongsTo(StockCat::class, 'CateId', 'CateId');
    }
}
