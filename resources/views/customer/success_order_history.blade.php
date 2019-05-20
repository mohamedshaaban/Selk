@extends('layout.app')
@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $( document ).ready(function() {
    $('#order-confirm').modal();
    window.localStorage.removeItem('cart');
    window.localStorage.removeItem('cartCount');
    window.localStorage.removeItem('cartTotal');
    window.localStorage.removeItem('cartId');
    });
    </script>
    @if($settings->banner_order_history)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_order_history) }}" class="img-responsive" alt="banner">

            <h2 class="text-uppercase">My Order <span class="text-uppercase">History</span></h2>
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
 <div id="order-confirm" class="modal-confirm modal fade">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2>{{ __('website.OrderConfirmation')}}</h2>
                <img src="/img/order-confirm.png" alt="confirmation">
                <p>
                        {{ __('website.Thankyou')}}<br>
                        {!!   __('website.forusing') !!} <span>{!!  __('website.Sellektes') !!}</span>{!!__('website.storetext') !!}
                </p>
                <p class="order-no">{{ __('website.order')}} No&colon; {{ $order->unique_id }}</p>
                <a href="{{ route('home') }}"><button class="btn text-uppercase btn-confirm">{{ __('website.ContinueShopping')}}</button></a>
            </div>
          </div>
        </div>
      </div>
@endsection
