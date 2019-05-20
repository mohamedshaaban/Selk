<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAmountOffer extends Model
{
    protected $fillable = [
        'id', 'amount', 'from', 'to', 'is_fixed', 'status'
    ];
}
