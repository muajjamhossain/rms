<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['rstrt_slug', 'expense_for', 'amount', 'pay_by'];
}
