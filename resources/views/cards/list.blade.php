@extends('layout.app')
@section('content')
@if($settings->banner_product_listing)
    <section class="sec-banner">
      <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_product_listing) }}" class="img-responsive" alt="banner">


        <h2 class="text-uppercase">
                {{ __("website.gift") }} <span class="text-uppercase"> {{ __("website.card") }}</span>
        </h2>
      </div>
    </section>
 @endif
    <div class="sec-crumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="/">{{ __("website.home_label") }}</a></li>
          <li class="active">{{ __("website.gift_card") }}</li>
        </ol>
      </div>
    </div>

    <section class="pb-45">
      <div class="container">
        <div class="">
            @foreach($cards as $card)
          <div class="col-md-6 white-gift">
            <h2 class="gift-head" style="color: {{ $card->color }}">{{ $card->name }}</h2>
            <div class="gift-img">
              <img src="{{ asset('uploads/'.$card->image) }}" alt="" />
              <h1 class="gift-price" style="color: {{ $card->color }}">{{ $currencyLabel }} <span>{{ $card->price * $currencyValue }}</span></h1>
              <p class="gift-code" style="color: {{ $card->color }}">
                    {{ __("website.your_gift_voucher_code") }} <br />
                <span>**** **** **** ****</span>
              </p>
            </div>
            <div class="col-md-10 col-md-offset-1 mt-20">
                @if(Auth::user())
                <a href="{{ route('cardInfo',$card->id) }}"><button class="button-main" type="button">{{ __("website.select_card") }}</button></a>
            @else
            <button class="button-main" onclick="$('#login-popup').click()" type="button">{{ __("website.select_card") }}</button></a>
            @endif
            </div>
          </div>
        @endforeach
<div class="col-md-12 tuto-gift">
                      <div class="mainhead text-center m-30">
                          <h2>{{
                    __("website.how_to_redeem")
                }} </h2>
                        </div>

                      <div class="col-md-10 text-center col-md-offset-1">
                          <div class="col-md-4"><h1>1</h1><p>{{
                    __("website.gift_enjoy_shopping")
                }}</p> </div>

                              <div class="col-md-4"><h1>2</h1><p>{{
                    __("website.add_the_gift")
                }}</p> </div>

                                  <div class="col-md-4"><h1>3</h1><p>{{
                    __("website.click_on_apply")
                }}</p> </div>,

                      </div>
                    </div>
        </div>
      </div>
    </section>



@endsection
