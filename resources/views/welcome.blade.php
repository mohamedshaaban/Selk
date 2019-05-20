@extends('layout.app') 
@section('content')

<div class="banner">
  <div class=" fullwidth">
    <div class="">
      <ul class="bannerSlider">
        <!-- 1. slide -->
        <li class="slide">
          <a href="#">
            <div class="slide__text">
              <!-- <h2>This is the otter.</h2> -->
            </div>
            <div class="slide__image">
              <img src="/img/bnnr.png" alt="" />
            </div>
          </a>
        </li>
        <!-- 2. slide -->
        <li class="slide">
          <a href="#">
            <div class="slide__text">
              <!-- <h2>Otters are cool. </h2> -->
            </div>
            <div class="slide__image">
              <img src="/img/bnnr1.jpg" alt="" />
            </div>
          </a>
        </li>
        <!-- 3. slide -->
        <li class="slide">
          <a href="#">
            <div class="slide__text">
              <!-- <h2>Otters are cool. </h2> -->
            </div>
            <div class="slide__image">
              <img src="/img/bnnr2.jpg" alt="" />
            </div>
          </a>
        </li>
        <!-- 3. slide -->
        <li class="slide">
          <a href="#">
            <div class="slide__text">
              <!-- <h2>Otters are cool. </h2> -->
            </div>
            <div class="slide__image">
              <img src="/img/bnnr3.jpg" alt="" />
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

@if($products->where('is_new',1)->count())
<section class="new-arrivals">
  <div class="container">
    <div class="mainhead text-center m-30">
      <h2>{{ __('website.new_arrival_label') }} </h2>
    </div>
    <products-row :products="{{ $products->where('is_new',1) }}"></products-row>
</section>
@endif

<section class="cats">
  <div class="mainhead text-center m-30">
    <h2>{{ __('website.out_categories') }} </h2>
  </div>
  @foreach ($sharedCategories->where('home',1)->slice(0, 5) as $category ) 
  @if($loop->first)
  @if($category->parent_id == 0)
  <a href="{{route('website.categories.index' , ['category_id'=> $category->id])}}">
  @else
  <a href="{{route('website.product.index' , ['categories' => $category->id])}}">
  @endif
  
    <div class="col-md-6 nmk">
      <img class="imgR" src="{{ asset('uploads/' . $category->image )}}" alt="" />
      <div class="cat-name">
        <p>{{ $category->name_en }}</p>
      </div>
    </div>
  </a>
  @else @if($loop->index == 1)
  <div class="col-md-6 plr-0">
    @endif
    @if($category->parent_id == 0)
    <a href="{{route('website.categories.index' , ['category_id'=> $category->id])}}">
    @else
    <a href="{{route('website.product.index' , ['categories' => $category->id])}}">
    @endif
      <div class="col-md-6 pl-0 mb-15 nmk1">
        <img class="imgR" src="{{ asset('uploads/' . $category->image )}}" alt="" />
        <div class="cat-name">
          <p>{{ $category->name_en }}</p>
        </div>
      </div>
    </a>
    @if($loop->index == 4)
  </div>
  @endif @endif @endforeach


</section>

<section class="new-arrivals features-products">
  <div class="container">
    <div class="mainhead text-center m-30">
      <h2>{{ __('website.featured_products_label')}}</h2>
    </div>
    <products-row :products="{{ $products->where('is_featured',1) }}"></products-row>
  </div>

</section>

<section class="brands">
  <div class="mainhead text-center m-30">
    <h2>{{ __('website.our_brands_label')}}</h2>
  </div>
  <div class="container">
    <ul class="brands-slid list-unstyled list-inline">
      @foreach ($brands as $brand )
      <li class="brandimg">
        <img src="{{ asset('uploads/' . $brand->image) }}" alt="{{ $brand->name_en }}" />
      </li>
      @endforeach
    </ul>
  </div>
</section>

@if($giftBoxes->count())

<section class="offers">
  <div class="col-md-8 pr-0">
    @foreach ($giftBoxes->slice(0, 2) as $giftBoxe)
        <a href="{{ $giftBoxe->url }}" class="col-md-12 row pr-0 mb-15">
            <img class="imgR" src="{{ asset('uploads/' . $giftBoxe['large_image_' . $lang] )}}" alt="" />
        </a> 
    @endforeach
  </div>
  @foreach ($giftBoxes->slice(2, 3) as $giftBoxe)
  <div class="col-md-4 pl-0  pr-0">
    <a href="{{ $giftBoxe->url }}" class="col-md-12 row  pr-0">
        <img class="imgR  pr-0" src="{{ asset('uploads/' . $giftBoxe['small_image_' . $lang] )}}" alt="" />
      </a>
  </div>
  @endforeach
</section>
@endif

<section class="app-dwnld pr-0 pl-0">
  <div class="container">
    <div class="col-md-11 col-md-offset-1">
      <img src="/img/mobile.png" alt="" />
      <div class="dwnltxt">
        <h1>{{ __('website.download_mobile_app_label') }}</h1>
        <ul class="list-unstyled listinline">
          <li>
            <a href="{{ $settings->app_store_link}}" target="_blank">
                <img src="/img/appl.png" alt="" />
              </a>
          </li>
          <li>
            <a href="{{ $settings->google_store_link}}" target="_blank">
            <img src="/img/ggl.png" alt="" />
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="bxz">
  @foreach (array_slice($instagramImages,0,7) as $instagramImage)
  <div class="thumb">
    <img src="{{$instagramImage->images->low_resolution->url}}" alt="" />
  </div>
  @endforeach
  <div class="thumbtxt">
    <p class="intrx">
      {{ __('website.enjoy_your_experince_with')}}
      <br /> {{ __('website.moment_with_us_label')}}
    </p>
    <ul class="list-unstyled list-inline">
      <li>
        <a href="{{ $settings->facebook}}" target="_blank">
            <img src="/img/fb.png" alt="" />
          </a>
      </li>
      <li>
        <a href="{{ $settings->twitter}}" target="_blank">
            <img src="/img/twir.png" alt="" />
          </a>
      </li>
      <li>
        <a href="{{ $settings->instagram}}" target="_blank">
            <img src="/img/insta.png" alt="" />
          </a>
      </li>
      <li class="text-left f-left">
        <p class="signtr">@Sellektes</p>
      </li>
    </ul>
  </div>
  @foreach (array_slice($instagramImages,7,7) as $instagramImage)
  <div class="thumb">
    <img src="{{$instagramImage->images->low_resolution->url}}" alt="" />
  </div>
  @endforeach
</section>
@endsection