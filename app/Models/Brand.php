<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Common;

class Brand extends Model
{
    protected $appends = [
        'name'
    ];
    protected $fillable = [
        'name_en', 'name_ar', 'image', 'top',
        'home', 'sort_order', 'status',
        'vend_updated_at', 'vend_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
