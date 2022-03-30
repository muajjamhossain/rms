<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['rstrt_slug', 'incom_for', 'amount', 'pay_by'];
}
