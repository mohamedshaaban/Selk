<?php

namespace App\Http\Controllers\Orders;

use App\Http\Classes\Vend;
use App\Http\Controllers\Knet\KnetController;
use App\Http\Interfaces\SlidersRepostoryInterface;
use App\Models\Area;
use App\Models\OrderStatus;
use App\Models\OrderTrack;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Carbon\Carbon;
use App\Models\Sliders;
use App\Mail\OrderMail;
use Mail;

use Dingo\Api\Routing\Helpers;
use Auth;
use App\User;
use App\Models\CartStorage;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAddress;
use App\Models\ShippingMethods;
use App\Models\GiftCartStorage;
use App\Models\CustomerGiftCards;
use App\Mail\VoucherCard;
use App\Mail\VoucherOwnerCard;
use Illuminate\Support\Str;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductOptionValues;
use App\Models\ProductsTogetherPrice;
use App\Models\DhlShippingInfo;

class OrdersController extends Controller
{
	use Helpers;

	public function placeOrder(Request $request, Vend $vend)
	{
        $cardId = [] ;
        $cartamount = 0 ;
		$this->orderValidation($request);

		$shipping_method_name = substr($request->get('shipping_method'), 0, 4);
		$isDhl  = false;
		if ($shipping_method_name == 'dhl_') {
			$isDhl = true;
			$dhlShippingID = explode("_", $request->get('shipping_method'))[1];
			$dhlShippingMethods = session('dhl_shipping_methods');
		}


		$pre_order = 0;

		$cart     = CartStorage::where('cart_id', session('cartId'))->first();
		$cartCard = GiftCartStorage::where('cart_id', session('cartCardId'))->first();

		$order = new Order();
		if ($cart) {
			$orderCreatedStatus = OrderStatus::where('is_default', 1)->first();
			$cartItems     = json_decode($cart->cart);
			$itemsQuantity = array();
			foreach (json_decode($cart->cart) as $item) {
				$itemsQuantity[$item->product_id] = $item->quantity;
			}
			$totalAfterGroup   = 0;
			$productWithPrices = ProductsTogetherPrice::whereIn('product_id', array_keys($itemsQuantity))->orWhereIn('with_product_id', array_keys($itemsQuantity))->get();
			foreach ($productWithPrices as $price) {
				if (array_key_exists($price->product_id, $itemsQuantity) && array_key_exists($price->with_product_id, $itemsQuantity)) {
					$quantity                                 = (min($itemsQuantity[$price->product_id], $itemsQuantity[$price->with_product_id]));
					$totalAfterGroup                          += $quantity * $price->price;
					$itemsQuantity[$price->product_id]      = $itemsQuantity[$price->product_id] - $quantity;
					$itemsQuantity[$price->with_product_id] = $itemsQuantity[$price->with_product_id] - $quantity;
				}
			}
			foreach (json_decode($cart->cart) as $item) {

				$totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
			}
			$totalAfterGroup = number_format((float)$totalAfterGroup, 2, '.', '');

			$shippingMethod = ShippingMethods::find($request->shipping_method);
			$giftcard       = CustomerGiftCards::where('card', $request->discount_code)->where('is_used', 0)->first();
			$total          = $totalAfterGroup;
			$order          = new Order();
			if ($giftcard) {
				$total               = $request->total - $giftcard->amount;
				$order->gift_card_id = $giftcard->id;
				$order->discount = $giftcard->amount;
				$giftcard->is_used   = 1;
				$giftcard->update();
			} else {

				$giftcard = Coupon::where('code', $request->discount_code)->first();
				if ($giftcard) {
					$order->coupon_id = $giftcard->id;
					if ($giftcard->is_fixed) {
						$total = $total - $giftcard->fixed;
                        $order->discount = $giftcard->fixed;
					} else {
						$amount = $total * $giftcard->percentage / 100;
                        $order->discount = $amount;
                        $total  = $total - $amount;
					}
				}
			}


			$order->user_id          = Auth::Id();
			$order->address_id       = $request->address_id;
			$order->billing_address_id       = $request->billing_address_id;
			$order->unique_id        = substr(\md5(uniqid(5)), 0, 6);
			$order->order_date       = Carbon::now();
			$order->sub_total        = $request->total;
			$order->delivery_charges = $isDhl ? $dhlShippingMethods[$dhlShippingID]['cost'] : $shippingMethod->price;
			$order->total            = $isDhl ? $dhlShippingMethods[$dhlShippingID]['cost'] + $total : $total + $shippingMethod->price;
			$order->payment_method   = $request->payment_method;
			$order->shipping_method  = $isDhl ? '' : $request->shipping_method;

			$order->save();

			if ($isDhl) {
				$this->setDhlShippingInfo($dhlShippingMethods[$dhlShippingID], $order);
			}

			$orderTack = new OrderTrack();
			$orderTack->order_id   = $order->id;
			$orderTack->order_status_id  = $orderCreatedStatus->id;
			$orderTack->save();

			$vendProducts = [];
			foreach ($cartItems as $item) {
				$options_index = array();
				if ($item->product->pre_order == 1) {
					$pre_order = 1;
				}
				$product           = Product::find($item->product_id);
				$product->quantity = $product->quantity - $item->quantity;
				$product->update();


				$orderProduct               = new OrderProduct();
				$orderProduct->order_id     = $order->id;
				$orderProduct->product_id   = $item->product_id;
				$orderProduct->quantity     = $item->quantity;
				$orderProduct->sub_total    = $item->price;
				$orderProduct->is_pre_order = $item->product->pre_order;
				$orderProduct->total        = $item->total;
				$orderProduct->save();

				if (isset($item->options)) {
					$options_index = implode('_', $item->options);
				}
				$vendProducts[] = [
					'vend_id'  => $item->product->vend_id,
					'quantity' => $item->quantity,
					'price'    => $item->total
				];

				if (isset($item->options)) {
					foreach ($item->options as $option) {
						$productoptionvalue = ProductOptionValues::where('product_id', $item->product_id)->where('option_id',$option)->first();

						$optionprice   = json_decode($productoptionvalue['price_combination'], true);
                        if($optionprice) {
                            $prev_quantity = $optionprice['options'][$options_index]['quantity'];

						$optionprice['options'][$options_index]['quantity'] = (($prev_quantity - $item->quantity) < -1 ? 0 : ($prev_quantity - $item->quantity));

                            $productoptionvalue->price_combination = json_encode($optionprice);
                            $productoptionvalue->update();


						if (isset($option)) {
							$orderProductOption = OrderProductOption::updateOrCreate([
								'order_product_id' => $orderProduct->id,
								'option_id'        => $option,
								'option_value_id'  => $productoptionvalue->option_value_id
							]);

						}
                        }

					}
				}
			}

			$vend->regSale($order->id, $vendProducts, optional(PaymentType::find($request->payment_method))->vend_id);

			$order->has_pre_order = $pre_order;
			$order->update();
			CartStorage::where('cart_id', session('cartId'))->delete();
			$request->session()->forget('cartId');
		}

		if ($cartCard) {
			$cartItems = json_decode($cartCard->cart);
			foreach ($cartItems as $item) {

				$gift = CustomerGiftCards::updateOrCreate([
					'card_id' => $item->product_id,
					'card'    => Str::random(4),
					'amount'  => $item->total,
					'email'   => $item->email,
					'name'   => $item->name ? $item->name : '',
					'is_used' => 0
				]);
                $cardId[] = $gift->id;
                $cartamount+=$item->total;
			}
			GiftCartStorage::where('cart_id', session('cartCardId'))->delete();
			$request->session()->forget('cartCardId');
		}
		$orders = Order::where('user_id', Auth::Id())->with('status')->OrderBy('id', 'DESC')->paginate(15);

		Mail::to(Auth::user()->email)->send(new OrderMail(Auth::user(), $order));

		if($request->payment_method == 3)
        {
            $knet = new KnetController();

            $knetRes = $knet->redirect($order->id ,$cardId,$cartamount);

            return ['status' => 'true', 'id' => $order->id, 'data'=>$knetRes ,'knetpayment'=>1];


        }
		return ['status' => 'true', 'id' => $order->id,'knetpayment'=>0];
	}
	public function placeCardOrder(Request $request, Vend $vend)
	{
		$this->orderCardValidation($request);

		$pre_order = 0;


		$cartCard = GiftCartStorage::where('cart_id', session('cartCardId'))->first();

		$order = new Order();
        $total = 0 ;
        $cardId = [] ;
		if ($cartCard) {
			$cartItems = json_decode($cartCard->cart);
			foreach ($cartItems as $item) {
                $total+= $item->total;
				$gift = CustomerGiftCards::updateOrCreate([
					'card_id' => $item->product_id,
					'card'    => Str::random(4),
					'amount'  => $item->total,
					'email'   => $item->email,
					'name'   => $item->name ?$item->name : '',
					'is_used' => 0
				]);
                $cardId[] = $gift->id;
//				$card = \App\Models\GiftCards::find($item->product_id);
//				Mail::to($item->email)->send(new VoucherCard($card, $gift,Auth::user()));
//                Mail::to(Auth::user()->email)->send(new VoucherOwnerCard($card, $gift,Auth::user()));
			}
			GiftCartStorage::where('cart_id', session('cartCardId'))->delete();
			$request->session()->forget('cartCardId');
		}
		$orders = Order::where('user_id', Auth::Id())->with('status')->OrderBy('id', 'DESC')->paginate(15);

//		Mail::to(Auth::user()->email)->send(new OrderMail(Auth::user(), $order));

		if($request->payment_method == 3)
        {
            $knet = new KnetController();
            $knetRes = $knet->cardRedirect($total , $cardId);

            return ['status' => 'true', 'id' => $order->id, 'data'=>$knetRes ,'knetpayment'=>1];


        }
		return ['status' => 'true', 'id' => $order->id,'knetpayment'=>0];
	}

	public function orders(Request $request)
	{
		$orders = Order::where('user_id', Auth::Id())->with('status')->OrderBy('id', 'DESC')->paginate(15);

		return $orders;
	}

	public function orderValidation(Request $request)
	{
		$messages = array('after' => __("validation.date_validation_error"));
		$this->validate($request, [
			'address_id'         => __('required'),
			'billing_address_id' => __('required'),
			'shipping_method'    => __('required'),
			'payment_method'     => __('required'),
		], $messages);
	}
	public function orderCardValidation(Request $request)
	{
		$messages = array('after' => __("validation.date_validation_error"));
		$this->validate($request, [
			'payment_method'     => __('required'),
		], $messages);
	}

	public function setDhlShippingInfo($dhlShippingInfo, $order)
	{
		
		$data = DhlShippingInfo::create([
			'order_id' => $order->id,
			'global_product_code' => $dhlShippingInfo['global_product_code'],
			'local_product_code' => $dhlShippingInfo['local_product_code'],
			'cost' => $dhlShippingInfo['cost'],
			'title' => $dhlShippingInfo['title'],
			'date' => $dhlShippingInfo['date'],
			'days' => $dhlShippingInfo['days'],
		]);

		Order::where('id', $order->id)->update(['dhl_shipping_info_id' => $data->id]);

		return $data->id;
	}
}
