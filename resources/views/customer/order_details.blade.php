@extends('layout.app')
@section('content')
@if($settings->banner_order_details)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_order_details) }}" class="img-responsive" alt="banner">


            <h2 class="text-uppercase">{{ __('website.my_label')}} <span class="text-uppercase">{{ __('website.profile_label')}}</span></h2>
        </div>
    </section>
@endif
    <div class="sec-crumb forgot-pass">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">{{ __('website.home_label')}}</a></li>
                <li><a href="{{ route('customer.my_profile') }}">{{ __('website.my_account_label_label')}}</a></li>
                <li class="active">{{ __('website.my_profile_label')}}</li>
            </ol>
        </div>
    </div>

    <section class="sec-cart">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12">

                    @foreach($order->orderproducts as $item)

                    <div class="row item-row">
                        <div class="col-xs-4">
                            <div class="item-img">
                              <p class="new-labl off"></p>

                              <img src="{{ ($item->product->main_image )}}" alt="disney">
                            </div>
                        </div>

                        <div class="col-xs-5 col-sm-4 col-md-5">
                            <!--<img src="{{ asset('uploads/'.$item->product->main_image )}}" alt="disney">-->
                            <p class="item-name">{{ $item->product->name_en }}</p>
                            <p class="new-price">{{ $currencyLabel }} {{ $item->product->price * $currencyValue }}</p>
                            <div style="margin-top: 10px;">
                                    {{ __('website.order_id')}} : <strong>{{ $order->unique_id }}</strong>
                            </div>
                            <div style="margin-top: 10px;">
                                @foreach($item->orderproductoption as $option)


                                    {{ ($option->option->name) }} : <strong>{{ ($option->optionValue->value) }}</strong>
                                    @endforeach
                            </div>
                            <div style="margin-top: 10px;">
                                    {{ __('website.qty_label')}} : <strong>{{ $item->quantity }}</strong>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-4 col-md-3">
                          <br><br>
                            <p class="total-text text-right">{{ __('website.total_label')}}</p>
                            <p class="total-price text-right">{{ $currencyLabel }} {{ $item->total * $currencyValue }}</p>
                        </div>
                    </div>
                    <hr>

                    @endforeach

                </div>
            </div>
        </div>

    </section>


@endsection
