<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class PaymentType extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'vend_id',
    ];


}
