@extends('layout.app')
@section('content')
@if($settings->banner_wishlist)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_wishlist) }}" class="img-responsive" alt="banner">


            <h2 class="text-uppercase">{{ __('website.Wish')}} <span class="text-uppercase">{{ __('website.List')}}</span></h2>
        </div>
    </section>
@endif
    <div class="sec-crumb forgot-pass">
        <div class="container">
            <ol class="breadcrumb">
                    <li><a href="/">{{ __('website.home_label')}}</a></li>
                    <li><a href="{{ route('customer.my_profile') }}">{{ __('website.my_account_label_label')}}</a></li>
                <li class="active">{{ __('website.Wish')}} {{ __('website.List')}}</li>
            </ol>
        </div>
    </div>
  <section class="sec-wish-list">
    <div class="container">
       @include('customer.includes.profile_menu')


          <wishlist :wish_list="{{ json_encode($products)}}"></wishlist>

    </div>
  </section>

@endsection
