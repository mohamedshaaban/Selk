@extends('layout.app')
@section('content')
@if($settings->banner_cart)
<section class="sec-banner">
    <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_cart) }}" class="img-responsive" alt="banner">


        <h2 class="text-uppercase">{{ __("website.my_cart_label") }}</h2>
    </div>
</section>
@endif
<div class="sec-crumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ url('/')}}">{{ __("website.home_label") }}</a></li>
            <li class="active">{{ __("website.my_cart_label") }}</li>
        </ol>
    </div>
</div>
<section class="pb-45 upcoming-events">

    <checkout-my-cart  :cart_list="{{ json_encode($cart)}}"  :currency="{{$currencies->where('id',$selected_currency)->first()}}"></checkout-my-cart>
</section>
@endsection
