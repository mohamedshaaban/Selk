<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\OptionValue;

class OrderProductOption extends Model
{
    protected $fillable = [
        'order_product_id', 'option_id', 'option_value_id'
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
