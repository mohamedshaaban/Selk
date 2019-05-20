<?php

namespace App\Http\Controllers\Checkout;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartStorage;
use App\Models\GiftCartStorage;
use App\Models\UserAddress;
use Auth;
use App\Models\ShippingMethods;
use App\Models\CustomerGiftCards;
use App\Models\Coupon;
use App\Models\Settings;
use App\Models\ProductsTogetherPrice;
use App\Http\Controllers\Checkout\DhlQuoteContoller;

class CheckoutController extends Controller
{
    public function MyCart()
    {
        $settings = Settings::find(1);
        $cart  = CartStorage::where('cart_id', session('cartId'))->paginate(15);

        return view('checkout.cart')->with(compact('cart', 'settings'));
    }
    public function checkout(Request $request)
    {
        if (!Auth::User()) {
            return redirect(route('login', 'cart=1'));
        }

        $countries = \App\Models\Countries::all();
        $provience = \App\Models\Provience::all();
        if (!session('cartId') && (!session('cartCardId'))) {
            return redirect('home');
        }
        $user = Auth::User();
        $shippingMethods = $shippingMethods = ShippingMethods::where('country_id', 1)->get();
        $shippingAddress = UserAddress::where('user_id',  Auth::Id())->where('type', 2)->with('provience')->with('countries')->get();

        $billingAddress = UserAddress::where('user_id',  Auth::Id())->where('type', 1)->with('provience')->with('countries')->get();
        $defaultuserAddress = UserAddress::where('user_id',  Auth::Id())->where('is_default', 1)->where('type', 2)->first();
        if (!$shippingAddress) {
            $defaultuserAddress = UserAddress::where('user_id',  Auth::Id())->where('is_default', 1)->first();
        }

        $cartTotal = 0;
        $cartItems = $this->getCartItems();
        $cartCardItems = $this->getCartCardItems();

        if((empty((array)$cartItems))&&(empty((array)$cartCardItems)))
        {
            return redirect(route('home'));
        }
        if ($defaultuserAddress) {
            $shippingMethods = ShippingMethods::where('country_id', $defaultuserAddress->governorate_id)->get();
        }
        if (!$defaultuserAddress) {
            $defaultuserAddress = UserAddress::where('user_id',  Auth::Id())->first();
            if (!$defaultuserAddress) {
                $record = new UserAddress();

                $defaultuserAddress = (object)array_combine($record->getFillable(),  array_fill(0, count($record->getFillable()), ''));
            }
        }

        $cartTotal = $this->getCartTotal($cartItems);
        $totalcrt = $cartTotal['totalcrt'];
        $totalAfterGroup = $cartTotal['totalAfterGroup'];
        $shippingMethods = [];
        $cities = \App\Models\Cities::all();
if((empty((array)$cartItems)))
{
    return view('checkout.cardCheckout')->with(compact('cartItems', 'totalAfterGroup', 'totalcrt', 'cartCardItems', 'shippingAddress', 'billingAddress', 'defaultuserAddress', 'user', 'shippingMethods', 'countries', 'provience','cities'));
}
        return view('checkout.checkout')->with(compact('cartItems', 'totalAfterGroup', 'totalcrt', 'cartCardItems', 'shippingAddress', 'billingAddress', 'defaultuserAddress', 'user', 'shippingMethods', 'countries', 'provience','cities'));
    }
    public function applyDiscount(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        $cart = CartStorage::where('cart_id', session('cartId'))->first();

        $itemsQuantity = array();
        foreach (json_decode($cart->cart) as $item) {
            $itemsQuantity[$item->product_id] = $item->quantity;
        }
        $totalAfterGroup = 0;
        $productWithPrices = ProductsTogetherPrice::whereIn('product_id', array_keys($itemsQuantity))->orWhereIn('with_product_id', array_keys($itemsQuantity))->get();
        foreach ($productWithPrices as $price) {
            if (array_key_exists($price->product_id, $itemsQuantity) && array_key_exists($price->with_product_id, $itemsQuantity)) {
                $quantity = (min($itemsQuantity[$price->product_id], $itemsQuantity[$price->with_product_id]));
                $totalAfterGroup += $quantity * $price->price;
                $itemsQuantity[$price->product_id] = $itemsQuantity[$price->product_id] - $quantity;
                $itemsQuantity[$price->with_product_id] = $itemsQuantity[$price->with_product_id] - $quantity;
            }
        }
        foreach (json_decode($cart->cart) as $item) {

            $totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
        }
        $totalAfterGroup = number_format((float)$totalAfterGroup, 2, '.', '');

        $total = $totalAfterGroup;

        $giftcard = CustomerGiftCards::where('card', $request->discount_code)->where('is_used', 0)->first();

        if ($giftcard) {
            $grand_total = $request->total - $giftcard->amount + $request->shippingcharges;
            return [
                'success' => true,
                'message' => 'coupun applied with ' . $giftcard->amount . ' KD'  ,
                'total' => $grand_total
            ];
        }

        $giftcard = Coupon::where('code', $request->discount_code)->where('status', 1)->where('from', '<=', $today)->where('to', '>=', $today)->first();

        if ($giftcard && $total >= $giftcard->minimum_order) {
            if ($giftcard->is_fixed) {
                $grand_total =  $total - ($giftcard->fixed  + $request->shippingcharges);
            } else {
                $amount = $request->total * $giftcard->percentage / 100;
                $grand_total = $total - $amount + $request->shippingcharges;
            }
            return [
                'success' => true,
                'message' => 'coupun applied with ' . ($giftcard->is_fixed == 1 ? $giftcard->fixed . ' KD' : $giftcard->percentage . '%'),
                'total' => $grand_total
            ];
        }

        return [
            'success' => false,
            'message' => __('website.coupon_is_not_valid'),
            'total' => ($total + $request->shippingcharges),

        ];
    }

    public function getShippingMethod(Request $request)
    {
        $response = [
            'success' => false,
            'html' => ''
        ];

        $userAddress = \App\Models\UserAddress::find($request->get('address_id'));

        if (!$userAddress) {
            return $response;
        }

        $shippingMethods =  ShippingMethods::where('country_id', $userAddress->governorate_id)->get();

        $cartItems = $this->getCartItems();
        $cartTotal = $this->getCartTotal($cartItems);
        $totalcrt = $cartTotal['totalcrt'];

        // dhl 
        $dhl = new DhlQuoteContoller();
        $dhl->sendRequest($userAddress, $cartItems);
        $dhlResponse = $dhl->getResponse();

        $dhl_shipping_methods = [];
        if ($dhlResponse && $dhlResponse['status'] == true) {
            $dhl_shipping_methods = $dhlResponse['data'];
            $request->session()->put('dhl_shipping_methods', $dhl_shipping_methods);
        }
        // end dhl

        $returnHTML = view('checkout.shipping_methods')
            ->with([
                'totalcrt' => $totalcrt,
                'shippingMethods' => $shippingMethods,
                'dhl_shipping_methods' => $dhl_shipping_methods
            ])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getCartTotal($cartItems)
    {
        $totalcrt = 0;
        $itemsQuantity = array();
        foreach ($cartItems as $item) {
            if (!$item) {
                continue;
            }
            $itemsQuantity[$item->product_id] = $item->quantity;
            $totalcrt += $item->quantity * $item->price;
        }
        $totalAfterGroup = 0;
        $productWithPrices = \App\Models\ProductsTogetherPrice::whereIn('product_id', array_keys($itemsQuantity))->orWhereIn('with_product_id', array_keys($itemsQuantity))->get();
        foreach ($productWithPrices as $price) {
            if (array_key_exists($price->product_id, $itemsQuantity) && array_key_exists($price->with_product_id, $itemsQuantity)) {
                $quantity = (min($itemsQuantity[$price->product_id], $itemsQuantity[$price->with_product_id]));
                $totalAfterGroup += $quantity * $price->price;
                $itemsQuantity[$price->product_id] = $itemsQuantity[$price->product_id] - $quantity;
                $itemsQuantity[$price->with_product_id] = $itemsQuantity[$price->with_product_id] - $quantity;
            }
        }
        foreach ($cartItems as $item) {

            $totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
        }
        $totalAfterGroup = number_format((float)($totalAfterGroup), 2, '.', '');;
        $cartCardStorage = \App\Models\GiftCartStorage::where('cart_id', session('cartCardId'))->first();

        if ($cartCardStorage) {
            foreach (json_decode($cartCardStorage->cart) as $item) {
                $totalAfterGroup += $item->total;
            }
        }

        return [
            'totalcrt' => $totalcrt,
            'totalAfterGroup' => $totalAfterGroup,
        ];
    }

    public function getCartItems()
    {
        $cartItems = new \stdClass();
        if (CartStorage::where('cart_id', session('cartId'))->first()) {
            $cartItems = json_decode(CartStorage::where('cart_id', session('cartId'))->first()->cart);
        }

        return $cartItems;
    }

    public function getCartCardItems()
    {
        $cartCardItems = new \stdClass();
        if (GiftCartStorage::where('cart_id', session('cartCardId'))->first()) {
            $cartCardItems = json_decode(GiftCartStorage::where('cart_id', session('cartCardId'))->first()->cart);
        }

        return $cartCardItems;
    }
}
