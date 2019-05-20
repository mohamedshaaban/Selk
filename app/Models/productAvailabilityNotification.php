<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductAvailabilityNotification extends Model
{

    const STATUS_PENDING = 0;
    const STATUS_SENDED = 1;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'product_id',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
