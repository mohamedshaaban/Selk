@extends('layout.app')
@section('content')
@if($settings->banner_product_details)
    <section class="sec-banner">
      <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_product_details) }}" class="img-responsive" alt="banner">

        <h2 class="text-uppercase">
          {{__('website.Gift_label')}} <span class="text-uppercase">{{__('website.Card_label')}}</span>
        </h2>
      </div>
    </section>
@endif
    <div class="sec-crumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="/">{{ __('website.Home_label') }}</a></li>
          <li><a href="{{ route('user.giftCard') }}">{{ __('website.GiftCard_label') }}</a></li>
          <li class="active">{{__('website.Gift Card Form')}}</li>
        </ol>
      </div>
    </div>
<giftcard :card="{{ json_encode($card)}}" :user="{{ json_encode($user)}}"></giftcard>

@endsection
