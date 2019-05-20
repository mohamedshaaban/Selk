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
@foreach($dhl_shipping_methods as $dhl_shipping_method)
@if(!isset($dhl_shipping_method['global_product_code']))
    @continue
@endif
<div class="row shipping-method-row">
    <div class="col-md-7">
        <label class="radio-container checkout-container">
            <span class="ship-method-title">{{ $dhl_shipping_method['text'] }}</span><br>
            <span class="ship-method-desc">{{ $dhl_shipping_method['title'] }}</span>
            <input type="radio" value="dhl_{{ $dhl_shipping_method['global_product_code'] }}"  onclick="updateShippingPriceDhL({{$dhl_shipping_method['cost']}},'{{ $dhl_shipping_method['text'] }}','{{ $dhl_shipping_method['title'] }}')" name="shipping_method">
            <span class="checkmark payment-check"></span>
        </label>
    </div>
    <div class="col-md-5">
        <p class="pull-right">{{ $currencyCode }} {{ $dhl_shipping_method['cost']  * $currencyValue }}</p>
    </div>
</div>
<hr>
@endforeach
