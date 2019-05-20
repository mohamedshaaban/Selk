<?php

namespace App\Http\Controllers\giftcart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartStorage;
use App\Models\GiftCartStorage;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Support\Str;
use App\Models\ProductsTogetherPrice;
use App\Models\ShippingMethods;

class CartController extends Controller
{

    public function validation(request $request)
    {
        $this->validate($request, [
            'amount' => 'required|min:1',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);

        return response()->json(true, 200);
    }
    public static function get(Request $request)
    {
        $cartStorage = CartStorage::where('cart_id', session('cartId'))->first();

        if (!$cartStorage) {
            return;
        }
        $totalCart  = 0;
        $cartCount = 0;
        foreach (json_decode($cartStorage->cart) as $item) {

            $totalCart += $item->total;
            $cartCount++;
        }
        $cartItems =  json_decode($cartStorage->cart);
        $itemsQuantity = array();
        foreach (json_decode($cartStorage->cart) as $item) {
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
        foreach (json_decode($cartStorage->cart) as $item) {

            $totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
        }
        $totalAfterGroup = number_format((float)$totalAfterGroup, 2, '.', '');
        ///Get Gift Card Cart
        $cartCardStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();
//        dd($cartCardStorage);
        if ($cartCardStorage) {
            foreach (json_decode($cartCardStorage->cart) as $item) {
                $totalAfterGroup += $item->total;
                $cartCount++;
            }
        }


        ///
        return json_encode(['cart' => $cartStorage->cart, 'cartId' => $cartStorage->cart_id, 'cartCount' => $cartCount, 'totalCart' => $totalAfterGroup]);
    }

    public static function add(Request $request)
    {

        $cartStorage = new GiftCartStorage();
        if (session('cartCardId') && GiftCartStorage::where('cart_id', session('cartCardId'))->first()) {
            $cartStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();
            $create = false;
        } else {
            $cartStorage = new GiftCartStorage();
            $create = true;
        }

        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }
        if ($create) {
            $cartStorage->cart_id  = Str::random(10);
        } else {
            $cartStorage->cart_id = session('cartCardId');
        }

        $countItems = 0;
        $totalCart = 0;

        $cart = array();
        $productIds = array();

        if ($cartStorage->cart) {


            foreach (json_decode($cartStorage->cart) as $item) {
                $itemcart = array();
                if (!$item) {
                    continue;
                }
                $itemcart['product_id'] = $item->product_id;
                $itemcart['image'] = $item->image;
                $itemcart['product'] = $item->product;
                $itemcart['options'] = $item->options;
                $itemcart['total'] = $item->price * $request['params']['quantity'];
                $itemcart['price'] = $item->price;
                $itemcart['quantity'] = $request['params']['quantity'];
                $itemcart['name'] = $item->name;
                $itemcart['email'] = $item->email;
                $itemcart['phone'] = $item->phone;

                $countItems++;
                $totalCart += $item->price;
                array_push($cart, $itemcart);
            }
        }
        $product = \App\Models\GiftCards::find($request['params']['product']['id']);

        $itemcart = array();

        $itemcart['product_id'] = $product->id;
        $itemcart['image'] = $product->image;
        $itemcart['product'] = $product;
        $itemcart['options'] = '';
        $itemcart['total'] = $request['params']['product']['price'] * $request['params']['quantity'];
        $itemcart['price'] = $request['params']['product']['price'];
        $itemcart['quantity'] = $request['params']['quantity'];
        $itemcart['name'] = $request['params']['name'];
        $itemcart['email'] = $request['params']['email'];
        $itemcart['phone'] = $request['params']['phone'];
        array_push($cart, $itemcart);
        $countItems++;
        $totalCart +=  $request['params']['product']['price'] ;


        $cartStorage->cart = json_encode($cart);
        //key exists, do stuff
        if ($create) {
            $cartStorage->save();
        } else {

            $cartStorage->update();
        }
        $cartStorage->refresh();
        $cartItems=array();
        $cartItemsStorage = CartStorage::where('cart_id', session('cartId'))->first();
        if ($cartItemsStorage) {
            $cartItems = json_decode($cartItemsStorage->cart);
        }
        if (!(empty((array)$cartItems))) {


            $itemsQuantity = array();
            foreach (json_decode($cartItemsStorage->cart) as $item) {
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
            foreach (json_decode($cartItemsStorage->cart) as $item) {

                $totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
            }
            $totalAfterGroup+=$totalCart;
        }
        else
        {

            $totalAfterGroup  = $totalCart;
        }

        $totalAfterGroup = number_format((float)$totalAfterGroup, 2, '.', '');
        session(['cartCardId' => $cartStorage->cart_id]);
        return json_encode(['cart' => $cartStorage->cart, 'cartCardId' => $cartStorage->cart_id, 'cartCount' => $countItems, 'totalCart' => $totalAfterGroup]);
    }

    public static function update(Request $request)
    {
        $countItems = 0;
        $totalCart = 0;
        $cartStorage = new GiftCartStorage();
        if (session('cartCardId') && GiftCartStorage::where('cart_id', session('cartCardId'))->first()) {
            $cartStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();
            $create = false;
        } else {
            $cartStorage = new GiftCartStorage();
            $create = true;
        }

        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }
        if (!session('cartCardId')) {
            $cartStorage->cart_id  = Str::random(10);
        } else {
            $cartStorage->cart_id = session('cartCardId');
        }



        $cart = array();
        $productIds = array();

        if ($cartStorage->cart) {

            foreach (json_decode($cartStorage->cart) as $item) {
                $productIds[] = $item->product_id;
            }

            foreach (json_decode($cartStorage->cart) as $item) {

                $itemcart = array();

                $itemcart['product_id'] = $item->product_id;
                $itemcart['image'] = $item->image;
                $itemcart['product'] = $item->product;
                $itemcart['options'] = $item->options;
                if ($request['params']['product']['id'] == $item->product_id) {
                    $itemcart['total'] = $request['params']['product']['price'] * ($item->quantity + $request['params']['quantity']);
                    $itemcart['price'] = $request['params']['product']['price'];
                    $countItems++;
                    if ($request['params']['increment'] == 'false') {
                        $itemcart['quantity'] = $item->quantity - $request['params']['quantity'];

                        $itemcart['total'] = $item->price * $itemcart['quantity'];
                    } else {
                        $itemcart['quantity'] = $item->quantity + $request['params']['quantity'];
                        $itemcart['total'] = $request['params']['product']['price'] * $itemcart['quantity'];
                    }
                    $totalCart += $itemcart['total'];
                } else {
                    $itemcart['quantity'] = $item->quantity;
                    $itemcart['total'] = $request['params']['product']['price'] * $itemcart['quantity'];
                    $totalCart += $itemcart['total'];
                    $itemcart['price'] = $request['params']['product']['price'];
                }
                $itemcart['name'] = $request['params']['name'];
                $itemcart['email'] = $request['params']['email'];
                $itemcart['phone'] = $request['params']['phone'];

                array_push($cart, $itemcart);
            }
        }
        if (!in_array($request['params']['product']['id'], $productIds)) {
            $product = \App\Models\GiftCards::find($request['params']['product']['id']);
            $itemcart = array();
            $countItems++;
            $itemcart['product_id'] = $product->id;
            $itemcart['image'] = $product->image;
            $itemcart['product'] = $product;
            $itemcart['options'] = '';
            $itemcart['total'] = $product->price * $request['params']['quantity'];
            $itemcart['price'] = $product->price;
            $itemcart['quantity'] = $request['params']['quantity'];
            $itemcart['name'] = $request['params']['name'];
            $itemcart['email'] = $request['params']['email'];
            $itemcart['phone'] = $request['params']['phone'];
            array_push($cart, $itemcart);
            $totalCart += $itemcart['total'];
        }

        $cartStorage->cart = json_encode($cart);
        //key exists, do stuff
        if ($create) {
            $cartStorage->save();
        } else {

            $cartStorage->update();
        }
        $cartStorage->refresh();
        session(['cartCardId' => $cartStorage->cart_id]);
        return json_encode(['cart' => $cartStorage->cart, 'cartCardId' => $cartStorage->cart_id, 'cartCount' => $countItems, 'totalCart' => $totalCart]);
    }

    public static function delete(Request $request)
    {


        $cartStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();


        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }

        $countItems = 0;
        $totalCart = 0;

        $cart = array();

        $totacart = 0;
        if ($cartStorage->cart) {

            foreach (json_decode($cartStorage->cart) as $item) {

                $itemcart = array();
                if (sizeof($item) == 0) {
                    continue;
                }
                if ($request->product_id == $item->product_id) {

                    // $cartStorage->cart$cartStorage->cart ;
                    $totacart = $item->price;
                    continue;
                }
                $itemcart['product_id'] = $item->product_id;
                $itemcart['image'] = $item->image;
                $itemcart['product'] = $item->product;
                $itemcart['options'] = $item->options;

                $itemcart['total'] = $request['params']['product']['price'] * $item->quantity;
                $itemcart['price'] = $request['params']['product']['price'];
                $itemcart['quantity'] = $item->quantity;

                $itemcart['total'] = $item->price * $item->quantity;
                $itemcart['price'] = $item->price;
                $itemcart['quantity'] = $item->quantity;
                $itemcart['name'] = $item->name;
                $itemcart['email'] = $item->email;
                $itemcart['phone'] = $item->phone;


                $countItems++;
                $totalCart += $itemcart['price'] * $itemcart['quantity'];
                array_push($cart, $itemcart);
            }


            $cartStorage->cart = json_encode($cart);
        }
        $cartStorage->update();

        $cartStorage->refresh();
        session(['cartId' => $cartStorage->cart_id]);
        if (!$cartStorage->cart) {
            session(['cartId' => '']);
        }

        $countItems--;
        $cartItemsStorage = CartStorage::where('cart_id', session('cartId'))->first();

        if (!$cartItemsStorage) {
            return;
        }
        $cartItems =  json_decode($cartItemsStorage->cart);
        $itemsQuantity = array();
        foreach (json_decode($cartItemsStorage->cart) as $item) {
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
        foreach (json_decode($cartItemsStorage->cart) as $item) {

            $totalAfterGroup += $itemsQuantity[$item->product_id] * $item->price;
        }
        $totalAfterGroup = number_format((float)$totalAfterGroup, 2, '.', '');
        return json_encode(['cart' => $cartStorage->cart, 'cartCardId' => $cartStorage->cart_id, 'cartCount' => $countItems>0 ? $countItems : 0, 'totalCart' => $totalCart+$totalAfterGroup, 'tobetrac' => $totacart]);
    }
    public function getShippingMethodInfo(Request $request)
    {
        return ShippingMethods::find($request->id);
    }
}
