@extends('layout.app')
@section('content')
@if($settings->banner_address_list)
  <section class="sec-banner">
    <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_address_list) }}" class="img-responsive" alt="banner">


      <h2 class="text-uppercase">{{ __('website.my') }}
        <span class="text-uppercase">{{ __('website.address_book_label') }}</span>
      </h2>
    </div>
  </section>
@endif
  <div class="sec-crumb forgot-pass">
    <div class="container">
      <ol class="breadcrumb">
            <li><a href="/">{{ __('website.home_label') }}</a></li>
            <li><a href="{{ route('customer.address_book') }}">{{ __('website.address_book_label') }}</a></li>
        <li class="active">{{ __('website.My Address Book') }}</li>
      </ol>
    </div>
  </div>

  <section class="my-profile">
    <div class="container">
       @include('customer.includes.profile_menu')
      <div class="col-md-9 ">
        <div class="small-h8">
          <h3 class="col-md-6 col-sm-6 col-xs-6 lft">{{ __('website.My Address Book') }}</h3>

        </div>
        @foreach($defaultUserAddress as $address )
        <div class="register_box mt-20 full-width">

          <div class="row">
            <div class="col-md-9 col-xs-9 col-sm-9 col-lg-9">
              <p class="head-addr">{{ $address->address_type }} Address
                <span>{{ __('website.primary_address') }}</span>
              </p>
              <p class="small-txt-addr">{{ $address->address_type }} : (<span class="tpyp">{{ $address->address_type }}</span>)</p>
              <p class="small-txt-addr">{{ __("website.Name_label") }} : {{ $address->user_label }} {{ $address->first_name }} {{ $address->last_name }}</p>
                <p class="small-txt-addr">{{ __("website.address_label") }} : {{ $address->first_address }} {{ $address->second_address }} </p>
               <p class="small-txt-addr">{{ __("website.city_label") }} : {{ $address->city }}</p>
                <p class="small-txt-addr">{{ __("website.territory_label") }} : {{ $address->province }}</p>
                <p class="small-txt-addr">{{ __("website.postcode_label") }} : {{ $address->post_code }}</p>
                <p class="small-txt-addr">{{ __("website.phone_label") }} : {{ $address->phone_no }}</p>
                <p class="small-txt-addr">{{ __("website.mobile_label") }} : {{ $address->mobile_no }}</p>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
              <a href="{{ route('customer.edit_address_book' , $address->id ) }}" class="rit redas">{{ __('website.Manage') }} {{ $address->address_type }} {{ __('website.Address') }}</a>
            </div>
          </div>
        </div>


        <div class="small-h8">
          <h3 class="col-md-6 col-sm-6 col-xs-6 lft"></h3>

        </div>

        @endforeach
        @if($userAddress->count() > 0 )
        <div class="small-h8 mt-30">
            <h3 class="col-md-6 col-sm-6 col-xs-6 lft">{{ __("website.Additional Address") }}</h3>

          </div>
        @endif
          <div class="register_box mt-20 full-width">

            <div class="row">
                @foreach($userAddress as $address )
              <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6">


              <p class="small-txt-addr">{{ $address->address_type }} : (<span class="tpyp">{{ $address->address_type }}</span>)</p>
                     <p class="small-txt-addr">{{ __("website.Name_label") }} : {{ $address->user_label }} {{ $address->first_name }} {{ $address->last_name }}</p>
                <p class="small-txt-addr">{{ __("website.Address") }} : {{ $address->first_address }} {{ $address->second_address }} </p>
                <p class="small-txt-addr">{{ __("website.city_label") }} : {{ $address->city }}</p>
                <p class="small-txt-addr">{{ __("website.territory_label") }} : {{ $address->province }}</p>
                <p class="small-txt-addr">{{ __("website.postcode_label") }} : {{ $address->post_code }}</p>
                <p class="small-txt-addr">{{ __("website.phone_label") }} : {{ $address->phone_no }}</p>
                <p class="small-txt-addr">{{ __("website.mobile_label") }} : {{ $address->mobile_no }}</p>
                <div class="address-buttn-grp">
                <a class="edit-adr" href="{{ route('customer.edit_address_book' , $address->id ) }}">
                <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="close-adr" href="{{ route('customer.delete_address_book' , $address->id) }}">
                <span class="glyphicon glyphicon-plus"></span>
                </a>
              </div>
              </div>
                @endforeach

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-25 clear col-md-offset-3">
                    <a href="{{ route('customer.create_address_book') }}" class="button-main p5" type="button" >{{ __("website.add_address") }}</a>
                  </div>
            </div>
          </div>






      </div>
  </section>

@endsection
