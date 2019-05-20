<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Common;

class Character extends Model
{
    protected $appends = [
        'name'
    ];
    protected $fillable = [
        'name_en', 'name_ar', 'image', 'top',
        'sort_order', 'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_characters', 'character_id', 'category_id');
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
