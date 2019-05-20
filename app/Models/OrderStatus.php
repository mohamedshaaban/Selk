<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserAddress;
use App\Models\OrderProduct;
use App\Models\Order;

class OrderStatus extends Model {
	protected $table = 'order_status';

	public function order() {
		return $this->hasMany( Order::class );
	}

	public function ordertrack() {
		return $this->hasOne( OrderTrack::class );
	}
}
