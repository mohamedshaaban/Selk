
  <footer>
    <div class="container text-center">

      <a href="{{ route('getPageInfo', ['slug'=>'aboutus']) }}" class="bold foot-main-h8">{{ __("website.about_us") }}</a>
      <ul class="list-unstyled list-inline">
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'services']) }}">{{ __("website.services") }}</a>
        </li>
        <li>
          <a href="{{ route('getFaqs') }}">{{ __("website.faq") }}</a>
        </li>
        <li>
          <a href="{{ route('website.common.career')  }}">{{ __("website.careers") }}</a>
        </li>
        <li>
          <a href="{{ route('website.common.contact_us') }}">{{ __("website.contact_us") }}</a>
        </li>
        <li>
          <a href="{{  route('website.common.sitemap') }}">{{ __("website.sitemap") }}</a>
        </li>
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'privacy']) }}">{{ __("website.privacy_policy") }}</a>
        </li>
      </ul>
      <a href="{{ route('getPageInfo', ['slug'=>'customer']) }}" class="bold foot-main-h8">{{ __("website.customer_service") }}</a>
      <ul class="list-unstyled list-inline">
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'how_it_works']) }}">{{ __("website.how_it_works") }} </a>
        </li>
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'refund_exchange']) }}">{{ __("website.refund_exchange") }}</a>
        </li>
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'shipment']) }}">{{ __("website.shipment") }}</a>
        </li>
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'tracking']) }}">{{ __("website.order_tracking") }}</a>
        </li>
        <li>
          <a href="{{ route('getPageInfo', ['slug'=>'cookies']) }}">{{ __("website.cookies_policies") }}</a>
        </li>
      </ul>
    </div>
    {{--  <div class="mthds">
      <div class="container text-center">
        <div class="shp">
                {{ __("website.our_couriers") }}:
          <img class="imgshp" src="/img/dhl.jpg" alt="" />
        </div>
        <div class="shp">
                {{ __("website.payment_methos") }} :
          <img class="imgshp" src="/img/Master-Card-icon.png" alt="" />
          <img src="/img/Visa-icon.png" class="imgshp" alt="" />
          <img src="/img/knet.png" class="imgshp" alt="" />
        </div>


          <div class="live-chat" data-spy="affix" data-offset-bottom="100">
          <div class="chat-box">
            <h4>LEAVE A MESSAGE <div class="pull-right clox">-</div></h4>
            <input type="text"  placeholder="Your Name (Optional)" id="" class="inpt">
            <input type="email" placeholder="Email Address" id="" class="inpt">
            <textarea placeholder="How can we help you?" id="" class="inpt"></textarea>
            <button class="button-main" type="button">SEND</button>
          </div>
          <button class="chat-clk">Live Chat <img src="/img/chat-icn.png" alt=""></button>
        </div>


      </div>
    </div>  --}}
    <!-- live chat -->



    <!-- live chat -->

    <div class="foot-btm text-center">
      <p>© {{ __("website.coypright") }} {{ __("website.right_reserved") }}</p>
      <p>{{ __("website.powered_by") }}
        <a href="http://www.mawaqaa.com">
          <img src="/img/mawaqaa.png" alt="">
        </a>
      </p>
    </div>
  </footer>

  <!-- modellll -->


   @include('popups.login')

 @include('popups.register')

@include('popups.register_confirmation')

