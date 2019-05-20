<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\Product;
use App\Common;

class OptionValue extends Model
{
    protected $appends = [
        'value'
    ];
    protected $fillable = [
        'id', 'option_id', 'value_en', 'value_ar', 'image'
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_values', 'option_value_id', 'product_id')
            ->withPivot('option_id', 'price_combination');;
    }

    public function getValueAttribute()
    {
        return Common::nameLanguage($this->value_en, $this->value_ar);
    }
}
