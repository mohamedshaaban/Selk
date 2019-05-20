@extends('layout.app')
@section('content')





@if($settings->banner_sitemap)
      <section class="sec-banner">
      <div class="banner">
         <img src="{{ asset('uploads/'.$settings->banner_sitemap) }}" class="img-responsive" alt="banner">
        <h2 class="text-uppercase">{{ __("website.sitemap") }}</span></h2>
      </div>
    </section>
@endif

    <section class="sec-sitemap">
        <div class="container">
            <div class="masonry">
                <div class="item">
                    <a href="{{ route('home') }}" class="head text-uppercase">{{ __("website.home_label") }}</a>
                </div>

                <div class="item">

                    <a href="{{ route('getPageInfo', ['slug'=>'aboutus']) }}" class="head text-uppercase">{{ __("website.about_us") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'services']) }}" class="text-uppercase">{{ __("website.services") }}</a>

                    <a href="{{ route('getFaqs') }}" class="text-uppercase">{{ __("website.faq") }}</a>
                    <a href="{{ route('website.common.career')  }}" class="text-uppercase">{{ __("website.careers") }}</a>
                    <a href="{{ route('website.common.sitemap') }}" class=" text-uppercase">{{ __("website.sitemap") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'privacy']) }}" class=" text-uppercase">{{ __("website.privacy_policy") }}</a>
                </div>

                <div class="item">
                    <a href="{{ route('getPageInfo', ['slug'=>'customer']) }}" class="head text-uppercase">{{ __("website.customer_service") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'how_it_works']) }}" class=" text-uppercase">{{ __("website.how_it_works") }} </a>
                    <a href="{{ route('getPageInfo', ['slug'=>'refund_exchange']) }}"class=" text-uppercase">{{ __("website.refund_exchange") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'shipment']) }}" class=" text-uppercase">{{ __("website.shipment") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'tracking']) }}" class=" text-uppercase">{{ __("website.order_tracking") }}</a>
                    <a href="{{ route('getPageInfo', ['slug'=>'cookies']) }}" class=" text-uppercase">{{ __("website.cookies_policies") }}</a>
                </div>

                <div class="item">
                    <a href="/products?new=new" class="head text-uppercase">{{ __("website.new_in") }}</a>
                    @foreach($categories as $category)
                    @if(isset($category->id))
                    <a href="{{route('website.categories.index' , ['category_id' => $category->id])}}" class="text-uppercase">{{$category->name_en}}</a>
                    @endif
                    @endforeach
                </div>

                <div class="item">
                    <a href="#" class="head text-uppercase">{{ __("website.download_app") }}</a>
                </div>

                <div class="item">
                        <a href="#" class="head text-uppercase">{{ __("website.brands_label") }}</a>
@foreach($brands as $brand)
    @if(isset($brand->id))
                    <a href="{{route('website.categories.index' , ['brand_id' => $brand->id])}}" class=" text-uppercase">{{ $brand->name_en }}</a>
                    @endif
    @endforeach
                </div>

                <div class="item">
                    <a href="#" class="head text-uppercase">{{ __("website.social_media") }}</a>
                </div>

                <div class="item">
                    <a href="{{route('website.characters.index')}}" class="head text-uppercase">{{ __("website.characters_label") }}</a>
                    @foreach($Characters as $Character)
                    @if(isset($Character->name_en))
                    <a href="#" class="text-uppercase">{{ $Character->name_en }}</a>
                    @endif
                    @endforeach
                </div>

                <div class="item">
                    <a href="{{ route('website.product.shop_by_interest')}}" class="head text-uppercase">{{ __("website.shop_by_interset") }}</a>
                    @foreach($authcategories as $category)
                    @if(isset($category->id))
                    <a href="{{route('website.categories.index' , ['category_id' => $category->id])}}" class="text-uppercase">{{$category->name_en}}</a>
                    @endif
                    @endforeach

                </div>
                <div class="item">
                    <a href="{{ route('user.giftCard') }}" class="head text-uppercase">{{ __("website.gift_card_label") }}</a>
                </div>
                <div class="item">
                    <a href="{{ route('website.product.index' ,['sales' => 'sales'])}}" class="head text-uppercase">{{ __("website.sales_offers_label") }}</a>
                </div>
            </div>
        </div>
    </section>


@endsection
