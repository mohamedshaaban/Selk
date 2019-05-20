<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\OptionValue;
use App\Common;

class Option extends Model
{
    protected $appends = [
        'name'
    ];

    protected $fillable = ['id', 'type', 'name_en', 'name_ar', 'vend_id', 'vend_updated_at'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_options', 'option_id', 'product_id');
    }

    public function optionValue()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
