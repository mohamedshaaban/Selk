<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserAddress;
use App\Models\OrderProduct;
use App\Models\Coupon;
use App\Models\CustomerGiftCards;
use App\Models\OrderTrack;
use App\Models\DhlShippingInfo;

class Order extends Model
{
    const VISA_PAYMENT_METHOD = 1;
    const MASTER_PAYMENT_METHOD = 2;
    const KNET_PAYMENT_METHOD = 3;
    const CASH_ON_DELIVERY_PAYMENT_METHOD = 4;


    protected $fillable = [
        'user_id',  'address_id',  'unique_id',  'order_date',
        'sub_total',  'delivery_charges',  'total',  'is_paid',  'payment_method',
        'shipping_method' , 'dhl_shipping_info_id'
    ];

    public static function getWithRelations($id = null, $clone = false)
    {
        $orders =  self::with([
            'orderProducts',
            'orderProducts.orderProductOption',
            'orderProducts.orderProductOption.option',
            'orderProducts.orderProductOption.optionValue',
            'user',
            'userAddress'
        ]);

        if ($clone) {
            return $orders;
        }
        if ($id) {
            return $orders->find($id);
        }

        return $orders->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderstatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethods::class, 'shipping_method');
    }
    public function customergiftcards()
    {
        return $this->hasOne(CustomerGiftCards::class);
    }
    public function coupon()
    {
        return $this->hasOne(Coupon::class );
    }
    public function ordertrack()
    {
        return $this->hasOne(OrderTrack::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }
    public function dhlShippingInfo()
    {
        return $this->belongsTo(DhlShippingInfo::class, 'dhl_shipping_info_id', 'id');
    }
}
