@extends('layout.app')
@section('content')
@if($settings->banner_checkout)
 <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_checkout) }}" class="img-responsive" alt="banner">


        <h2 class="text-uppercase"><span class="text-uppercase">{{ __("website.checkout_label") }}</span></h2>
        </div>
    </section>
@endif
@php
$totalcrt = 0 ;
$total  = 0 ;
$itemsQuantity=array();
foreach($cartItems as $item)
{
    if(!$item)
    {
    continue;
    }
    $itemsQuantity[$item->product_id]=$item->quantity;
  $totalcrt += $item->quantity*$item->price;
}
$totalAfterGroup= 0 ;
$productWithPrices=App\Models\ProductsTogetherPrice::whereIn('product_id',array_keys($itemsQuantity))->orWhereIn('with_product_id',array_keys($itemsQuantity))->get();
foreach($productWithPrices as $price)
{
if(array_key_exists($price->product_id , $itemsQuantity)&&array_key_exists($price->with_product_id , $itemsQuantity))
{
    $quantity = (min($itemsQuantity[$price->product_id] , $itemsQuantity[$price->with_product_id]));
    $totalAfterGroup+=$quantity*$price->price;
    $itemsQuantity[$price->product_id]=$itemsQuantity[$price->product_id]-$quantity;
    $itemsQuantity[$price->with_product_id]=$itemsQuantity[$price->with_product_id]-$quantity;
}
}
foreach ($cartItems as $item) {

$totalAfterGroup+=$itemsQuantity[$item->product_id]*$item->price;

}
$totalAfterGroup = number_format((float)($totalAfterGroup), 2, '.', '');;
        $cartCardStorage = \App\Models\GiftCartStorage::where('cart_id', session('cartCardId'))->first();
//        dd($cartCardStorage);
        if ($cartCardStorage) {
            foreach (json_decode($cartCardStorage->cart) as $item) {
                $totalAfterGroup += $item->total;
                
            }
        }
@endphp

    <div class="sec-crumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">{{ __("website.home_label") }}</a></li>
                <li class="active">{{ __("website.checkout_label") }}</li>
            </ol>
        </div>
    </div>

    <section class="sec-checkout">
        <div class="container">
            <div id="checkout_submit_form_errors" class="row checkout_submit_form_errors">

            </div>
            <div class="row">
                <div class="col-sm-8">
                    <ul class="nav nav-tabs text-center">
                        <li class="active"><a data-toggle="tab" href="#item-details" class="shipping-tab text-uppercase">{{ __("website.Shipping") }}</a></li>
                        <li class="pull-right"><a data-toggle="tab" href="#del-ret" class="review-tab text-uppercase">{{ __("website.reviews_payment") }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="item-details" class="tab-pane fade payment-tab in active">
                            <p class="check-mony-order" id="allShippingAddress">{{ __("website.choose_address") }}</p>
                           @foreach($shippingAddress as $address)
                              <hr>
                              <br>
                              <div class="row">
                                  <div class="col-xs-1 Checkout-address-checkbox">
                                      <input type="radio" name="address_id" value="{{ $address->id }}" id="address_id" onclick="showBillingAddress({{ $address->id }})" class="form-radio address-radio-check">
                                  </div>
                                    <div class="col-xs-11 Checkout-address-text">
                                        <p class=""><span>{{ $address->address_type }}</span></p>
                                        <p class="">{{ __("website.Name_label") }} : {{ $address->user_label.' '.$address->first_name.' '.$address->last_name }}</p>
                                        <p class="">{{ __("website.address_label") }} : {{ $address->first_address }}</p>
                                        <p class="">{{ __("website.city_label") }} : {{ $address->city }}</p>
                                        @if(isset($address->provience))
                                        <p class="">{{ __("website.territory_label") }} : {{ $address->provience->title }}</p>
                                        @endif
                                        <p class="">{{ __("website.postcode_label") }} : {{ $address->post_code }}</p>
                                        <p class="">{{ __("website.phone_label") }} : {{ $address->phone_no }}</p>
                                        <p class="">{{ __("website.mobile_label") }} : {{ $address->mobile_no }}</p>
                                    </div>
                              </div>
                            <br>
                            @endforeach
                            <div class="">
                              <a class="text-uppercase add-new-address11 show-form">{{ __("website.add_address") }}</a>
                            </div>
                            <br>
                            <div class="hidden-form" style="display: none;">
                                <form id="addShippingAddressForm" class="form-horizontal" role="form">
                                    <input type="hidden" value="2" name="is_shipping" />
                                  @csrf
                                  <fieldset>
                                      <!-- Form Name -->
                                      <legend class="text-uppercase">{{ __("website.Shipping_Address") }}

                                      </legend>
                                      <!-- Text input-->
                                      <div class="form-group">
                                          <div class="col-sm-12">
                                              <input type="email" value="{{ $user->email }}" disabled="" placeholder="{{ __("website.email_address_req") }}" class="inpt form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text" placeholder="{{ __("website.address_type") }}" required="" name="address_type" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                                <select class="form-control" placeholder="{{ __("website.mr") }}" required="" name="user_label"  required="" id="user_label">
                                                    <option value="mr">{{ __("website.mr") }}</option>
                                                    <option value="mrs">{{ __("website.mrs") }}</option>
                                                </select>
                                            </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input class="form-control" required="" type="text" name="first_name" required="" value="{{ $user->first_name }}" placeholder="{{ __("website.first_name_label") }}">
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" required="" name="last_name" required=""value="{{ $user->last_name }}"  placeholder="{{ __("website.last_name_label") }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <select class="inpt country" name="governorate_id" required="" id="governorate_id">
                                      <option value="">{{ __("website.country_label") }}</option>
                                      @foreach($countries as $country)
                                      <option value="{{ $country->id }}">{{ $country->title }}</option>
                                      @endforeach


                                      </select>
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" name="first_address" required="" placeholder="{{ __("website.addressline1") }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text"  name="city" required=""  placeholder="{{ __("website.city_req") }}" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" name="second_address" required="" placeholder="{{ __("website.addressline2") }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text"  name="post_code" required="" placeholder="{{ __("website.postcode_labelreq") }}" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                              <select class="inpt province" name="province" id="province" required="">
                                      <option value="">{{ __("website.territory_label") }}</option>
                                     @foreach($provience as $provienc)
                                      <option value="{{ $provienc->id }}">{{ $provienc->title }}</option>
                                      @endforeach


                                      </select>
                                          </div>
                                      </div>
                                      <div class="form-group">

                                          <div class="col-sm-6">
                                              <input type="number" name="phone_no"  placeholder="{{ __("website.phone_label") }}" class="form-control carrer_ph_nu">
                                          </div>

                                          <div class="col-sm-6">
                                              <input type="number" name="mobile_no"  placeholder="{{ __("website.mobile_label") }}" class="form-control carrer_ph_nu">
                                          </div>
                                      </div>
                                      <input type="button" class="btn btn-primary new addShippingAddress" id="addShippingAddress" value="{{ __("website.submit_label") }}">
                                  </fieldset>
                              </form>
                              <div class="checkout_new_address_errors">

                            </div>
                            </div>
                            <br>
                            <form>
                                <fieldset>

                                    <legend class="ship-methd-lgnd text-uppercase">{{ __("website.Shipping_Methods") }}</legend>

                                   @foreach($shippingMethods as $method)
                                    @if($totalcrt >= $settings->free_delivery_amount &&$method->is_free ==1  )
                                    <div class="row shipping-method-row">
                                        <div class="col-md-7">
                                            <label class="radio-container checkout-container">
                                                <span class="ship-method-title">{{ $method->title }}</span><br>
                                                <span class="ship-method-desc">{{ $method->description }}</span>
                                                <input type="radio" checked value="{{ $method->id }}"  onclick="updateShippingPrice({{ $method->price }} , {{ $method->id }} )" name="shipping_method">
                                                <span class="checkmark payment-check"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="pull-right">{{ $currencyCode }} {{ $method->price * $currencyValue }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    @elseif($method->is_free !=1 )
                                    <div class="row shipping-method-row">
                                            <div class="col-md-7">
                                                <label class="radio-container checkout-container">
                                                    <span class="ship-method-title">{{ $method->title }}</span><br>
                                                    <span class="ship-method-desc">{{ $method->description }}</span>
                                                    <input type="radio" value="{{ $method->id }}"  onclick="updateShippingPrice({{ $method->price }} , {{ $method->id }} )" name="shipping_method">
                                                    <span class="checkmark payment-check"></span>
                                                </label>
                                            </div>
                                            <div class="col-md-5">
                                                <p class="pull-right">{{ $currencyCode }} {{ $method->price * $currencyValue }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                   @endforeach
                                </fieldset>
                                <fieldset>
                                    <legend class="ship-methd-lgnd text-uppercase">{{ __("website.Delivery_Date") }}</legend>
                                    <div class="row shipping-method-row">
                                        <div class="col-xs-6 col-sm-12 relative">
                                            <input type="date" class="next-date inpt" >
                                            <input type="date" name="preferred-date" disabled required class="absolute-date inpt">
                                        </div>

                                    </div>
                                    <div class="row shipping-method-row">

                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div id="del-ret" class="tab-pane fade payment-tab">
                            <fieldset>
                                <legend class="text-uppercase">{{ __("website.Payment") }}</legend>
                                <div class="row">
                                    <div class="col-xs-12">

                                        <label class="radio-container" style="margin-top: 0;">
                                          <input type="radio" checked="checked" name="radio22">
                                          <span class="checkmark payment-check"></span>
                                          <b>{{ __("website.money_order") }}</b>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">

                                  @if($defaultuserAddress && isset($defaultuserAddress->id))

                                    <div class="col-xs-1 Checkout-address-checkbox">
                                      <input type="checkbox" name="billing" id="radio-three" value="{{ $defaultuserAddress->id }}" class="form-radio address-radio-check" checked="checked">
                                  </div>

                                  <div class="col-xs-11 Checkout-address-text">
                                      <label for="radio-one" class="radio-check-lbl address-check-lbl">{{ __("website.billiing_shipping_same") }}</label>
                                      <p class=""><span>{{ $defaultuserAddress->address_type }} </span></p>

                                      <p class="">{{ __("website.Name_label") }} : <span class="addres_label">{{ $defaultuserAddress->user_label.' '.$defaultuserAddress->first_name.' '.$defaultuserAddress->last_name }}</span></p>
                                      <p class="">{{ __("website.address_label") }} : <span class="addres_address">{{ $defaultuserAddress->first_address }}</span> </p>
                                      <p class="">{{ __("website.city_label") }} : <span class="addres_city">{{ $defaultuserAddress->city }}</span></p>

                                      <p class="">{{ __("website.territory_label") }} : <span class="addres_provience">{{ optional($defaultuserAddress->provience)->title_en }}</span></p>
                                      <p class="">{{ __("website.postcode_label") }} : <span class="addres_postcode">{{ $defaultuserAddress->post_code }}</span></p>
                                      <p class="">{{ __("website.phone_label") }} : <span class="addres_phone">{{ $defaultuserAddress->phone_no }}</span></p>
                                      <p class="">{{ __("website.mobile_label") }} : <span class="addres_mobile">{{ $defaultuserAddress->mobile_no }}</span></p>
                                  </div>
                                    @endif
                                </div>
                                <div id="hide-billing"  style="display: none">
                                    <p class="check-mony-order"  id="allBillingAddress">{{ __("website.Choose_Billing_Address")}}</p>

                                     @foreach($billingAddress as $address)
                              <hr>
                              <br>
                              <div class="row">
                                  <div class="col-xs-1 Checkout-address-checkbox">
                                      <input type="radio" name="billing_address_id" id="billing_address_id" class="form-radio address-radio-check">
                                  </div>
                                    <div class="col-xs-11 Checkout-address-text">
                                        <p class=""><span>{{ $address->address_type }}</span></p>
                                        <p class="">{{ __("website.Name_label") }} : {{ $address->user_label.' '.$address->first_name.' '.$address->last_name }}</p>
                                        <p class="">{{ __("website.address_label") }} : {{ $address->first_address }}</p>
                                        <p class="">{{ __("website.city_label") }} : {{ $address->city }}</p>
                                        @if(isset($address->provience))
                                        <p class="">{{ __("website.territory_label") }} : {{ $address->provience->title }}</p>
                                        @endif
                                        <p class="">{{ __("website.postcode_label") }} : {{ $address->post_code }}</p>
                                        <p class="">{{ __("website.phone_label") }} : {{ $address->phone_no }}</p>
                                        <p class="">{{ __("website.mobile_label") }} : {{ $address->mobile_no }}</p>
                                    </div>
                              </div>
                            <br>
                            @endforeach
                                    <div class="">
                                      <a class="text-uppercase add-new-address11 show-form2">{{ __("website.add_address") }}</a>
                                    </div>
                                    <br>
                                    <div class="hidden-form2 " style="display: none;">
                                      <form id="addBillingAddressForm" class="form-horizontal" role="form">
                                    <input type="hidden" value="1" name="is_shipping" />
                                  @csrf
                                  <fieldset>
                                      <!-- Form Name -->
                                      <legend class="text-uppercase">{{ __("website.Shipping_Address") }}

                                      </legend>
                                      <!-- Text input-->
                                      <div class="form-group">
                                          <div class="col-sm-12">
                                              <input type="email" value="{{ $user->email }}" disabled="" placeholder="{{ __("website.email_address_req") }}" class="inpt form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text" placeholder="{{ __("website.address_type") }}" required="" name="address_type" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                                <select class="form-control" placeholder="{{ __("website.mr") }}" required="" name="user_label" required="" id="user_label">
                                                        <option value="mr">{{ __("website.mr") }}</option>
                                                        <option value="mrs">{{ __("website.mrs") }}</option>
                                                </select>
                                            </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input class="form-control" required="" type="text" name="first_name" required="" value="{{ $user->first_name }}" placeholder="{{ __("website.first_name_label") }}">
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" required="" name="last_name" required=""  placeholder="{{ __("website.last_name_label") }}" value="{{ $user->last_name }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <select class="inpt country" name="governorate_id" required="" id="governorate_id">
                                      <option value="">{{ __("website.country_label") }}</option>
                                      @foreach($countries as $country)
                                      <option value="{{ $country->id }}">{{ $country->title }}</option>
                                      @endforeach


                                      </select>
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" name="first_address" required="" placeholder="{{ __("website.addressline1") }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text"  name="city" required=""  placeholder="{{ __("website.city_req") }}" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                              <input type="text" name="second_address" required="" placeholder="{{ __("website.addressline2") }}" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-sm-6">
                                              <input type="text"  name="post_code" required="" placeholder="{{ __("website.postcode_labelreq") }}" class="form-control">
                                          </div>
                                          <div class="col-sm-6">
                                             <select class="inpt province" name="province" id="province" required="">
                                      <option value="">{{ __("website.territory_label") }}</option>
                                     @foreach($provience as $provienc)
                                      <option value="{{ $provienc->id }}">{{ $provienc->title }}</option>
                                      @endforeach


                                      </select>
                                          </div>
                                      </div>
                                      <div class="form-group">

                                          <div class="col-sm-6">
                                              <input type="number" name="phone_no"  placeholder="{{ __("website.phone_label") }}" class="form-control carrer_ph_nu">
                                          </div>

                                          <div class="col-sm-6">
                                              <input type="number" name="mobile_no"  placeholder="{{ __("website.mobile_label") }}" class="form-control carrer_ph_nu">
                                          </div>
                                      </div>
                                      <input type="button" class="btn btn-primary new addShippingAddress" id="addBillingAddress" value="{{ __("website.submit_label") }}">
                                  </fieldset>
                              </form>
                                    </div>
                                </div><!--/.hidebilling-->
                            </fieldset>

                            <div class="row summary-row">
                              <p class="payment-method col-sm-12">{{ __("website.payment_methos") }}</p>
                            </div>
                            <div class="row summary-row">
                                <div class="col-xs-6 col-sm-5">
                                    <label class="radio-container payment-container">
                                        <input type="radio"  value="1" name="payment_method">
                                        <span class="checkmark payment-check"></span>
                                        <img src="/img/visa.png" alt="">
                                    </label>
                                </div>
                                <div class="col-xs-6 col-sm-7">
                                    <label class="radio-container payment-container">
                                        <input type="radio" value="2" name="payment_method">
                                        <span class="checkmark payment-check"></span>
                                        <img class="master-card" src="/img/mastercard.png" alt="">
                                    </label>
                                </div>
                            </div>
                            <div class="row summary-row">
                                <div class="col-xs-6 col-sm-5">
                                    <label class="radio-container payment-container">
                                        <input type="radio" value="3" name="payment_method">
                                        <span class="checkmark payment-check"></span>
                                        <img src="/img/knett.png" alt="">
                                    </label>
                                </div>
                                <div class="col-xs-6 col-sm-7">
                                    <label class="radio-container payment-container">
                                        <input type="radio" value="4" name="payment_method">
                                        <span class="checkmark payment-check"></span>
                                        Cash On Delivery
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default panel-order-summary">
                        <div class="panel-heading">
                            <h3 class="panel-title text-uppercase text-center">{{ __("website.order_summary") }}</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" id="stacked-menu">
                                  <!-- Cart Items collapsed menu -->
                                  <li class="parent-li">
                                      <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#items">{{ sizeof($cartItems)+sizeof($cartCardItems) }} Items In Cart</a>
                                      <ul class="nav nav-pills nav-stacked collapse in" id="items">
                                          <!--Item One -->

                                          @foreach($cartItems as $item)

                                          @php
                                            if(!$item)
                                            {
                                            continue;
                                            }
                                          $total += $item->quantity*$item->price;
                                          @endphp
                                          <li data-parent="#categories">
                                              <div class="row item-in-cart-row">
                                                <div class="col-xs-3 col-sm-3 col-md-4">
                                                  <div class="item-img">
                                                    <img src="{{ asset($item->image) }}" alt="">
                                                  </div>
                                                </div>
                                                <div class="col-xs-5 col-sm-5 col-md-5">
                                                  <p class="description">{{ $item->product->name_en }}</p>

                                                  <p class="quantity">{{ __("website.Qty") }}&ThinSpace;&colon;&ThinSpace;<span>{{ $item->quantity }}</span></p>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-3">
                                                  <p class="price pull-right">{{ $currencyCode }}&ThinSpace;{{ $item->price * $currencyValue }}</p>
                                                </div>
                                              </div>

                                              @if(isset($item->options_value))
                                              <div class="row item-details-row">
                                                <div class="col-md-5 col-md-offset-4">
                                                    <a class="view-details" data-toggle="collapse" href="#item1">{{ __("website.View_details") }}</a>
                                                    <ul class="nav nav-pills nav-stacked collapse in text-left" id="item1">

                                                     @foreach($item->options_value as $key=>$value)
                                                        <li>

                                                        <p>{{ $value->option_name }}&ThinSpace;&colon;<span> {{ $value->option_value_name  }}</span></p>
                                                      </li>
                                                     @endforeach
                                                    </ul>
                                                </div>
                                              </div>
                                              @endif
                                          </li>
                                          @endforeach
                                          @foreach($cartCardItems as $item)
                                          @php

                                          $total += $item->price;
                                          @endphp
                                          <li data-parent="#categories">
                                              <div class="row item-in-cart-row">
                                                <div class="col-xs-3 col-sm-3 col-md-4">
                                                  <div class="item-img">
                                                    <img src="/uploads/{{ asset('uploads/'.$item->image) }}" alt="">
                                                  </div>
                                                </div>
                                                <div class="col-xs-5 col-sm-5 col-md-5">
                                                  <p class="description">{{ $item->product->name_en }}</p>
                                                  <p class="quantity">{{ __("website.Qty") }}&ThinSpace;&colon;&ThinSpace;<span>{{ $item->quantity }}</span></p>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-3">
                                                  <p class="price pull-right">{{ $currencyCode }}&ThinSpace;{{ $item->price  * $currencyValue }}</p>
                                                </div>
                                              </div>
                                              @if($item->options)
                                              <div class="row item-details-row">
                                                <div class="col-md-5 col-md-offset-4">
                                                    <a class="view-details" data-toggle="collapse" href="#item1">{{ __("website.View_details") }}</a>
                                                    <ul class="nav nav-pills nav-stacked collapse in text-left" id="item1">
                                                     @foreach($item->options as $key=>$value)
                                                        <li>
                                                        <p>{{ $key }}&ThinSpace;&colon;<span>{{ $value }}</span></p>
                                                      </li>
                                                     @endforeach
                                                    </ul>
                                                </div>
                                              </div>
                                              @endif
                                          </li>
                                          @endforeach
                                      </ul>
                                  </li>
                                  <input type="hidden" id="total" name="total" value="{{ $totalAfterGroup }}" />
                                  <!-- Sub Total -->
                                  <li class="parent-li">
                                    <p class="text-uppercase sub-total-text">{{ __("website.sub_total") }}</p>
                                    <p class="sub-total-value pull-right">{{ $currencyCode }} {{ $totalAfterGroup * $currencyValue }}</p>
                                  </li>

                                  <!-- Shipping Charges -->
                                  <li class="parent-li">
                                    <p class="text-uppercase shipping-charges-text">{{ __("website.Shipping_Charges") }}</p>
                                    <p class="shipping-charges-value pull-right">{{ $currencyCode }} <span class="shippingcharges">00</span></p>
                                    <input type="hidden" id="shippingcharges" />
                                  </li>

                                  <!-- Apply Discount Code -->
                                  <li class="parent-li discount-li hidden">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a class="apply-discount" data-toggle="collapse" href="#apply-discount">{{ __("website.apply_discount") }}</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="nav nav-pills nav-stacked collapse in" id="apply-discount">
                                                        <li>
                                                            <input type="text" id="discount_code" placeholder="{{ __("website.enter_apply_discount") }}">
                                                        </li>
                                                        <span class="success discount_code_success_message"></span>
                                                        <span class="error discount_code_error_message"></span>
                                                        <li>
                                                            <button class="text-uppercase" id="apply_discount">{{ __("website.apply_discount") }}</button>
                                                        </li>
                                                        <li>
                                                            <a href="" class="pull-left" data-toggle="modal" data-target="#cur-promotion">{{ __("website.see_promotions") }}</a>
                                                        </li>
                                                      </ul>
                                                </div>
                            
                                            </div>
                                        </div>
                                      </div>
                                  </li>

                                  <!-- Grand Total -->
                                  <li class="parent-li">
                                    <p class="text-uppercase grand-total-text">{{ __("website.Grand_Total") }}</p>
                                    <p class="grand-total-value pull-right">{{ $currencyCode }} <span class="totalcharges">{{ $totalAfterGroup * $currencyValue }}</span></p>
                                  </li>
                            </ul>
                        </div>
                    </div>

                    <input type="submit" id="next-btn" class="btn next-btn new text-uppercase" value="{{ __("website.next") }}">


                    <div class="panel panel-default panel-ship-to hidden">
                        <div class="panel-heading">
                            <h3 class="panel-title text-uppercase text-center">{{ __("website.ship_to") }}
                               <a href=""><img src="/img/edit-pen.png" class="pull-right" alt=""></a>
                              </h3>
                        </div>
                        <div class="panel-body">

                            <p class="">{{ __("website.Name_label") }} : <span class="addres_label">{{ $defaultuserAddress->user_label.' '.$defaultuserAddress->first_name.' '.$defaultuserAddress->last_name }}</span></p>
                            <p class="">{{ __("website.address_label") }} : <span class="addres_address">{{ $defaultuserAddress->first_address }}</span> </p>
                            <p class="">{{ __("website.city_label") }} : <span class="addres_city">{{ $defaultuserAddress->city }}</span></p>
                            @if(isset($defaultuserAddress->provience))
                            <p class="">{{ __("website.territory_label") }}: <span class="addres_provience">{{ optional($defaultuserAddress->provience)->title_en }}</span></p>
                            @endif
                            <p class="">{{ __("website.postcode_label") }} : <span class="addres_postcode">{{ $defaultuserAddress->post_code }}</span></p>
                            <p class="">{{ __("website.phone_label") }} : <span class="addres_phone">{{ $defaultuserAddress->phone_no }}</span></p>
                            <p class="">{{ __("website.mobile_label") }} : <span class="addres_mobile">{{ $defaultuserAddress->mobile_no }}</span></p>
                        </div>
                    </div>

                    <div class="panel panel-default panel-ship-method hidden">
                        <div class="panel-heading">
                            <h3 class="panel-title text-uppercase text-center">{{ __("website.Shipping_Methods") }}
                              <a href=""><img src="/img/edit-pen.png" class="pull-right" alt=""></a>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <p>Standard</p>
                            <p>(normally 4-5 business days,
                            unless otherwise noted)</p>
                        </div>
                    </div>
                    <div class="row i-agree hidden">
                        <div style="position: relative; z-index: 100;" class="col-xs-1 Checkout-address-checkbox">
                            <input type="checkbox" name="address" id="radio-one" class="form-radio address-radio-check">
                        </div>
                          <div class="col-xs-11 Checkout-address-text">
                              <label for="radio-one" style="line-height: 40px; padding-left: 10px;" class="radio-check-lbl address-check-lbl">{{ __("website.agree_terms") }}</label>
                          </div>

                    </div>
                    <br>
                    @csrf
                    <button type="button" id="placeOrderBtn" class="btn text-uppercase btn-place-oreder hidden" >{{ __("website.Place_Order") }}</button>

                </div>
            </div>

        </div>
    </section>

@endsection
