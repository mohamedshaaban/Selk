@extends('layout.app')
@section('content')

    @if($settings->banner_cart)
        <section class="sec-banner">
            <div class="banner">

                <img src="{{ asset('uploads/'.$settings->banner_cart) }}" class="img-responsive" alt="banner">


                <h2 class="text-uppercase">{{ __("website.knet_info_label") }}</h2>
            </div>
        </section>
    @endif
    <div style="clear: both;height: 100px;"></div>

    <section class="sec-cart">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12">



                        <div class="row item-row">

                            <div class="col-xs-5 col-sm-12 col-md-12 Checkout-address-text">
                                <h2>{{ __("website.order_processed_label") }}</h2>
                                <h3>{{ __("website.knet_info_label") }}</h3>
                                @foreach($orderTransaction->toArray() as $key=>$value)
                                 <p >{{ ucwords(str_replace("_", " ",$key)) }} :  {{ $value }}</p>
                                @endforeach
                                    <p >Date :  {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                            </div>

                        </div>
                        <hr>



                </div>
            </div>
        </div>

    </section>

@endsection
