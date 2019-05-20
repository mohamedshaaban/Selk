<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProductOption;
use Illuminate\Support\Facades\DB;

class OrderProduct extends Model
{
    protected $table='order_products';
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'sub_total', 'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProductOption()
    {
        return $this->hasMany(OrderProductOption::class, 'order_product_id');
    }
    public function getMostSelling()
    {
        $products = Product::whereIn('id',OrderProduct::groupBy('product_id')->selectRaw('*, sum(quantity) as sum')->limit(3)->pluck('product_id'))->get();
        return $products;
         
        
    }
}
