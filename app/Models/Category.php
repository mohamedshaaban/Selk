<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;
use App\Common;

class Category extends Model
{
    protected $appends = [
        'name'
    ];
    protected $fillable = [
        'name_en', 'name_ar', 'description_en', 'description_ar',
        'image', 'top', 'home', 'sort_order', 'status', 'parent_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
