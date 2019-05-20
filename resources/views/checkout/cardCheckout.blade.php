@extends('layout.app') 
@section('content') @if($settings->banner_checkout)
<section class="sec-banner">
    <div class="banner">
        <img src="{{ asset('uploads/'.$settings->banner_checkout) }}" class="img-responsive" alt="banner">
        <h2 class="text-uppercase"><span class="text-uppercase">{{ __("website.checkout_label") }}</span></h2>
    </div>
</section>
@endif @php $total = 0 ; 
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

                    <li class="active"><a data-toggle="tab" href="#del-ret" class="review-tab text-uppercase">{{ __("website.reviews_payment") }}</a></li>
                </ul>
                <div class="tab-content">

                    <div id="del-ret" class="tab-pane fade payment-tab in active">


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

                                    @foreach($cartItems as $item) @php if(!$item) { continue; } $total += $item->quantity*$item->price; 
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
                                    @endforeach @foreach($cartCardItems as $item) @php $total += $item->price; 
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
                                                <p class="price pull-right">{{ $currencyCode }}&ThinSpace;{{ $item->price * $currencyValue }}</p>
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


                            <!-- Apply Discount Code -->
                            <li class="parent-li discount-li ">
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






                <div class="row i-agree ">
                    <div style="position: relative; z-index: 100;" class="col-xs-1 Checkout-address-checkbox">
                        <input type="checkbox" name="address" id="radio-one" class="form-radio address-radio-check">
                    </div>
                    <div class="col-xs-11 Checkout-address-text">
                        <label for="radio-one" style="line-height: 40px; padding-left: 10px;" class="radio-check-lbl address-check-lbl"><a href="{{ route('getPageInfo','terms_conditions') }}" target="_blank">{{ __("website.agree_terms") }}</a></label>
                    </div>

                </div>
                <br> @csrf
                <button type="button" id="placeCardOrderBtn" class="btn text-uppercase btn-place-oreder ">{{ __("website.Place_Order") }}</button>

            </div>
        </div>

    </div>
</section>
@endsection
