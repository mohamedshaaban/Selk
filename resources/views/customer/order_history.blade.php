@extends('layout.app')
@section('content')
@if($settings->banner_order_history)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_order_history) }}" class="img-responsive" alt="banner">

            <h2 class="text-uppercase">{{ __('website.My Order')}} <span class="text-uppercase">{{ __('website.History')}}</span></h2>
        </div>
    </section>
@endif
    <div class="sec-crumb forgot-pass">
        <div class="container">
            <ol class="breadcrumb">
                    <li><a href="/">{{ __('website.home_label')}}</a></li>
                    <li><a href="{{ route('customer.my_profile') }}">{{ __('website.my_account_label_label')}}</a></li>
                <li class="active">{{ __('website.my_order_history_label_label')}}</li>
            </ol>
        </div>
    </div>
  <section class="my-profile">
    <div class="container">
       @include('customer.includes.profile_menu')
      <div class="col-md-9 ">

          <orders :orders_list="{{ json_encode($orders)}}"></orders>
      </div>
    </div>
  </section>

@endsection
