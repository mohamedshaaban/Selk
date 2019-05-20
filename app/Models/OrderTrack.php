<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserAddress;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\OrderStatus;
class OrderTrack extends Model
{
    protected $table = 'order_track';
    public function order()
    {
        return $this->belongsToMany(Order::class);
    }   
    public function orderstatus()
    {
        return $this->belongsToMany(OrderStatus::class);
    }  
}
