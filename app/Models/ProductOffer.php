<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductOffer extends Model
{
    protected $fillable = [
        'id', 'product_id', 'value', 'from', 'to', 'is_fixed'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
