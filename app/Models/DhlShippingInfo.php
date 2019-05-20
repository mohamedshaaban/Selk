<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DhlShippingInfo extends Model
{
    protected $fillable = [
        'global_product_code',
        'local_product_code',
        'order_id',
        'cost',
        'title',
        'date',
        'days',
        'currency',
        'label_file',
        'tracking_number',
        'service'
    ];
}
