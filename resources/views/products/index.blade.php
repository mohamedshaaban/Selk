{{--
<product-list :products="{{ $products }}"></product-list> --}}
@extends('layout.app')
@section('content')
@if($settings->banner_product_listing)
<section class="sec-banner">
    <div class="banner">

        <img src="{{ asset('uploads/'.$settings->banner_product_listing) }}" class="img-responsive" alt="banner">

        <h2 class="text-uppercase">{{ __("website.Products") }} </h2>
    </div>
</section>
@endif
<section class="sec-product-list">

    <products
    :max_price="{{$products->max('price') ?:1000}}"
    :min_price="{{ $products->min('price')?:1}}"
    :options="{{ $options }}"
    :categories="{{$categories}}"
    :brands="{{$brands}}"
    :products_list="{{ json_encode($products)}}"
    :google_ads = "{{$googleAds}}"
    ></products>
</section>
@endsection
