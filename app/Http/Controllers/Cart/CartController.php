<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartStorage;
use App\Models\GiftCartStorage;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Support\Str;
use App\Models\ShippingMethods;
use App\Models\ProductOptionValues;
use App\Models\ProductsTogetherPrice;

class CartController extends Controller
{
    public static function get(Request $request)
    {

        $cartStorage = CartStorage::where('cart_id', session('cartId'))->first();
        $totalAfterGroup = 0;
        $totalCart = 0;
        $cartCount = 0;
        if ($cartStorage) {



            foreach (json_decode($cartStorage->cart) as $item) {

                $totalCart += $item->total;
                $cartCount++;
            }
            $cartItems = json_decode($cartStorage->cart);
            $itemsQuantity = array();
            foreach (json_decode($cartStorage->cart) as $item) {
                $itemsQuantity[$item->product_id] = $item->quantity;
            }

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
        return json_encode(['cart' => isset($cartStorage->cart) ? $cartStorage->cart : json_encode([]), 'cartCard' => isset($cartCardStorage->cart) ? $cartCardStorage->cart :json_encode([]),'cartId' => isset($cartStorage->cart_id) ? $cartStorage->cart_id : '', 'cartCount' => $cartCount, 'totalCart' => $totalAfterGroup]);
    }

    public static function add(Request $request)
    {

        $cartStorage = new CartStorage();
        if (session('cartId') && CartStorage::where('cart_id', session('cartId'))->first()) {
            $cartStorage = CartStorage::where('cart_id', session('cartId'))->first();
            $create = false;
        } else {
            $cartStorage = new CartStorage();
            $create = true;
        }

        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }
        if (!session('cartId')) {
            $cartStorage->cart_id  = Str::random(10);
        } else {
            $cartStorage->cart_id = session('cartId');
        }

        $countItems = 0;
        $totalCart = 0;

        $cart = array();
        $productIds = array();

        if ($cartStorage->cart) {

            foreach (json_decode($cartStorage->cart) as $item) {

                if (isset($item->product_id)) {
                    $productIds[] = $item->product_id;
                }
            }

            foreach (json_decode($cartStorage->cart) as $item) {
                if (!$item) {
                    continue;
                }
                $option_id = array();
                $itemcart = array();
                $price = $item->price;
                $optionvalues = $item->options_value;

                if ($request['params']['options'] && $request['params']['options'] != '' && $request['params']['options'] != null && $request['params']['product']['id']==$item->product_id) {

                    $optionindex = implode('_', $request['params']['options']);

                    $productoptionvalue = ProductOptionValues::where('product_id', $item->product_id)->first();

                    $optionprice = json_decode($productoptionvalue['price_combination'], true)['options'][$optionindex]['price'];


                    if ($optionprice != 0) {
                            $price = $optionprice;
                        }

                    $optionvalues = \App\Models\OptionValue::whereIn('id', $request['params']['options'])->get();


                    $itemcart['options'] = $request['params']['options'];
                    foreach ($optionvalues as $optionvalue) {

                        $itemcart['options_value'][] = [
                            'option_value_name' => $optionvalue->value_en ? $optionvalue->value_en : '',
                            'option_name' => $optionvalue ? $optionvalue->option->name_en : ''
                        ];
                    }

                }
                else
                {
                    $optionvalues = $item->options_value;
                    foreach ($optionvalues as $optionvalue) {

                        $itemcart['options_value'][] = [
                            'option_value_name' => $optionvalue->option_value_name ? $optionvalue->option_value_name : '',
                            'option_name' => $optionvalue->option_name ? $optionvalue->option_name : ''
                        ];
                    }

                }


                if (isset($item->product_id)) {

                    $itemcart['product_id'] = $item->product_id;
                    $itemcart['image'] = $item->image;
                    $itemcart['product'] = $item->product;

                    // $item->options;
                    // $itemcart['options_value'] = $optionvalue;
                    if ($request['params']['product']['id'] == $item->product_id) {
                        $itemcart['total'] = $price * $request['params']['quantity'];
                        $itemcart['price'] = $price;
                        $itemcart['quantity'] = $request['params']['quantity'];
                    } else {
                        $itemcart['total'] = $price * $item->quantity;
                        $itemcart['price'] = $price;
                        $itemcart['quantity'] = $item->quantity;
                    }

                    $countItems++;
                    $totalCart += $itemcart['price']  * $itemcart['quantity'];
                    array_push($cart, $itemcart);
                }
            }
        }
        if (!in_array($request['params']['product']['id'], $productIds)) {
            $product = \App\Models\Product::whereId($request['params']['product']['id'])->with('brand')->with('options')->with('optionvalues')->first();
            $itemcart = array();
            $price = $product->price;

            $optionvalues = array();


            if ($request['params']['options'] && $request['params']['options'] != '' && $request['params']['options'] != null) {
                $optionindex = implode('_', $request['params']['options']);
                $productoptionvalue = ProductOptionValues::where('product_id', $request['params']['product']['id'])->first();
                $optionprice = json_decode($productoptionvalue['price_combination'], true)['options'][$optionindex]['price'];
                if ($optionprice != 0) {
                    $price = $optionprice;
                }
                $optionvalues = \App\Models\OptionValue::whereIn('id', $request['params']['options'])->get(); //->pluck('value_en');
            }

            $itemcart['product_id'] = $product->id;
            $itemcart['image'] = $product->main_image_path;
            $itemcart['product'] = $product;
            $itemcart['options'] = $request['params']['options'];
            foreach ($optionvalues as $optionvalue) {
                $itemcart['options_value'][] = [
                    'option_value_name' => $optionvalue ? $optionvalue->value_en : '',
                    'option_name' => $optionvalue ? $optionvalue->option->name_en : ''
                ];
            }
            // $itemcart['options_value'] = $optionvalue;
            $itemcart['total'] = $price * $request['params']['quantity'];
            $itemcart['price'] = $price;
            $itemcart['quantity'] = $request['params']['quantity'];
            array_push($cart, $itemcart);
            $countItems++;
            $totalCart += $price * $request['params']['quantity'];
        }

        $cartStorage->cart = json_encode($cart);
        //key exists, do stuff
        if ($create) {
            $cartStorage->save();
        } else {

            $cartStorage->update();
        }
        $cartStorage->refresh();
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
        $cartCardStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();
//        dd($cartCardStorage);
        if ($cartCardStorage) {
            foreach (json_decode($cartCardStorage->cart) as $item) {
                $totalAfterGroup += $item->total;
                $countItems++;
            }
        }
        session(['cartId' => $cartStorage->cart_id]);

        return json_encode(['cart' => $cartStorage->cart, 'cartId' => $cartStorage->cart_id, 'cartCount' => $countItems, 'totalCart' => $totalAfterGroup]);
    }

    public static function update(Request $request)
    {
        $countItems = 0;
        $totalCart = 0;
        $cartStorage = new CartStorage();
        if (session('cartId') && CartStorage::where('cart_id', session('cartId'))->first()) {
            $cartStorage = CartStorage::where('cart_id', session('cartId'))->first();
            $create = false;
        } else {
            $cartStorage = new CartStorage();
            $create = true;
        }

        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }
        if (!session('cartId')) {
            $cartStorage->cart_id  = Str::random(10);
        } else {
            $cartStorage->cart_id = session('cartId');
        }



        $cart = array();
        $productIds = array();

        if ($cartStorage->cart) {

            foreach (json_decode($cartStorage->cart) as $item) {
                $productIds[] = $item->product_id;
            }

            foreach (json_decode($cartStorage->cart) as $item) {

                $itemcart = array();
                $optionvalues = array();
                $itemcart['product_id'] = $item->product_id;
                $itemcart['image'] = $item->image;
                $itemcart['product'] = $item->product;
                $itemcart['options'] = [];
                if (isset($item->options)) {
                    $itemcart['options'] = $item->options;
                }

                $price = $item->price;
                if (isset($request['params']['options']) && $request['params']['options'] != '' && $request['params']['options'] != null && $item->product_id == $request['params']['product']['id']) {
                    $optionindex = implode('_', $request['params']['options']);
                    $productoptionvalue = ProductOptionValues::where('product_id', $item->product_id)->first();
                    $optionprice = json_decode($productoptionvalue['price_combination'], true)['options'][$optionindex]['price'];
                    if ($optionprice != 0) {
                        $price = $optionprice;
                    }
                    $itemcart['options'] = $request['params']['options'];
                }
                $optionvalues = $item->options_value;
                foreach ($optionvalues as $optionvalue) {

                    $itemcart['options_value'][] = [
                        'option_value_name' => $optionvalue->option_value_name ? $optionvalue->option_value_name : '',
                        'option_name' => $optionvalue->option_name ? $optionvalue->option_name : ''
                    ];
                }
                if ($request['params']['product']['id'] == $item->product_id) {
                    $itemcart['total'] = $price * ($item->quantity + $request['params']['quantity']);
                    $itemcart['price'] = $price;
                    $countItems++;
                    if ($request['params']['increment'] == 'false') {
                        $itemcart['quantity'] = $item->quantity - $request['params']['quantity'];

                        $itemcart['total'] = $price * $itemcart['quantity'];
                    } else {
                        $itemcart['quantity'] = $item->quantity + $request['params']['quantity'];
                        $itemcart['total'] = $price * $itemcart['quantity'];
                    }
                    $totalCart += $itemcart['total'];
                } else {

                    $itemcart['quantity'] = $item->quantity;
                    $itemcart['options_value'] = isset($item->options_value) ?$item->options_value : '';
                    $itemcart['total'] = $price * $itemcart['quantity'];
                    $totalCart += $itemcart['total'];
                    $itemcart['price'] = $price;
                }

                array_push($cart, $itemcart);
            }
        }
        if (!in_array($request['params']['product']['id'], $productIds)) {
            $product = \App\Models\Product::whereId($request['params']['product']['id'])->with('brand')->with('options')->with('optionvalues')->first();
            $itemcart = array();
            $countItems++;
            $itemcart['product_id'] = $product->id;
            $itemcart['image'] = $product->main_image_path;
            $itemcart['product'] = $product;
            $itemcart['options'] = $request['params']['options'];
            $itemcart['total'] = $product->price * $request['params']['quantity'];
            $itemcart['price'] = $product->price;
            $itemcart['quantity'] = $request['params']['quantity'];
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
        $totalAfterGroup = 0;
        $itemsQuantity = array();
        foreach (json_decode($cartStorage->cart) as $item) {
            $itemsQuantity[$item->product_id] = $item->quantity;
        }
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
        $cartCardStorage = GiftCartStorage::where('cart_id', session('cartCardId'))->first();
//        dd($cartCardStorage);
        if ($cartCardStorage) {
            foreach (json_decode($cartCardStorage->cart) as $item) {
                $totalAfterGroup += $item->total;
                $countItems++;
            }
        }
        session(['cartId' => $cartStorage->cart_id]);
        return json_encode(['cart' => $cartStorage->cart, 'cartId' => $cartStorage->cart_id, 'cartCount' => $countItems, 'totalCart' => $totalAfterGroup]);
    }

    public static function delete(Request $request)
    {

        $cartStorage = new CartStorage();
        if (session('cartId') && CartStorage::where('cart_id', session('cartId'))->first()) {
            $cartStorage = CartStorage::where('cart_id', session('cartId'))->first();
            $create = false;
        } else {
            $cartStorage = new CartStorage();
            $create = true;
        }

        if (Auth::User()) {
            $cartStorage->user_id = Auth::Id();
        } else {
            $cartStorage->user_id =  Str::random(10);
        }
        if (!session('cartId')) {
            $cartStorage->cart_id  = Str::random(10);
        } else {
            $cartStorage->cart_id = session('cartId');
        }

        $countItems = 0;
        $totalCart = 0;

        $cart = array();
        $productIds = array();

        if ($cartStorage->cart) {

            foreach (json_decode($cartStorage->cart) as $item) {

                $itemcart = array();
                if (sizeof($item) == 0) {
                    continue;
                }
                if ($request->product_id == $item->product_id) {
                    continue;
                }
                $itemcart['product_id'] = $item->product_id;
                $itemcart['image'] = $item->image;
                $itemcart['product'] = $item->product;
                $itemcart['options'] = array();
                if (isset($item->options)) {
                    $itemcart['options'] = $item->options;
                }


                $itemcart['total'] = $item->price * $item->quantity;
                $itemcart['price'] = $item->price;
                $itemcart['quantity'] = $item->quantity;

                $itemcart['total'] = $item->price * $item->quantity;
                $itemcart['price'] = $item->price;
                $itemcart['quantity'] = $item->quantity;
                $optionvalues = $item->options_value;
                foreach ($optionvalues as $optionvalue) {

                    $itemcart['options_value'][] = [
                        'option_value_name' => $optionvalue->option_value_name ? $optionvalue->option_value_name : '',
                        'option_name' => $optionvalue->option_name ? $optionvalue->option_name : ''
                    ];
                }

                $countItems++;
                $totalCart += $item->price * $item->quantity;
                array_push($cart, $itemcart);
            }
            $cartStorage->cart = json_encode($cart);
        }
        $cartStorage->update();

        $cartStorage->refresh();
        $totalAfterGroup = 0;
        $itemsQuantity = array();
        foreach (json_decode($cartStorage->cart) as $item) {
            $itemsQuantity[$item->product_id] = $item->quantity;
        }
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
        session(['cartId' => $cartStorage->cart_id]);
        if (!$cartStorage->cart) {
            session(['cartId' => '']);
        }

        $countItems--;
        return json_encode(['cart' => $cartStorage->cart, 'cartId' => $cartStorage->cart_id, 'cartCount' => $countItems, 'totalCart' => $totalAfterGroup]);
    }
    public function getShippingMethodInfo(Request $request)
    {
        return ShippingMethods::find($request->id);
    }
}
