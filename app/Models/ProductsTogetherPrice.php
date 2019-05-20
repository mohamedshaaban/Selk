<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductsTogetherPrice extends Model
{
    protected $fillable = [
        'id' , 'product_id' , 'with_product_id', ' price'
    ];


    public function productWith(){
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }
    public function productBelong(){
        return $this->belongsTo(Product::class , 'with_product_id','id');
    }
}
