@extends('layout.app')
@section('content') @if($settings->banner_product_details)
<section class="sec-banner">
    <div class="banner">

        <img src="{{ asset('uploads/'.$settings->banner_product_details) }}" class="img-responsive" alt="banner">

        <h2  class="text-uppercase">{{ $product->name  }} </h2>
    </div>
</section>
@endif
<section class="sec-item-details">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="single-item slider-for">
                            <div class="single-item-img">
                                <img src="{{ $product->main_image_path }}" alt="">
                            </div>
                            @foreach ($product->images_path as $image)
                            <div class="single-item-img">
                                <img src="{{$image}}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="multiple-item slider-nav">
                            <img src="{{$product->main_image_path}}" alt=""> @foreach ($product->images_path as $image)
                            <img src="{{$image}}" alt=""> @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 item-data">
                <div class="item-img">
                    @if($product->brand->image)
                    <img src="{{ asset('uploads/' . $product->brand->image)}}" alt="{{$product->brand->name_en}}">
                    @endif
                </div>

                <h2>{{ $product->short_description_en }}</h2>
                <product-review :rating="{{ count($product->reviews) ? round($product->reviews->sum('rate') / $product->reviews->count('rate')) : 0 }}"
                    :product="{{$product}}"></product-review>
                <product-option :size_charts="{{ json_encode($sizeChart) }}" :free_delivery_amount="{{$settings->free_delivery_amount}}" :option_values="{{$optionValues}}" :product="{{$product}}"></product-option>
            </div>
        </div>
    </div>
</section>

<section class="sec-details-tabs">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs text-center">
                    <li class="active"><a data-toggle="tab" href="#item-details">{{ __("website.item_details") }}</a></li>
                    <li><a data-toggle="tab" href="#del-ret">{{ __("website.delivery") }} &amp; {{ __("website.returns") }}</a></li>
                    <li><a data-toggle="tab" href="#review">{{ __("website.reviews") }}</a></li>
                </ul>
                <div class="tab-content">
                    <div id="item-details" class="tab-pane fade in active">
                        <p>
                            {{ $product->description_en}}
                        </p>
                    </div>
                    <div id="del-ret" class="tab-pane fade">
                        <p> {{ $product->delivery_and_return_en }}</p>
                    </div>
                    <div id="review" class="tab-pane fade">
                        @foreach ($product->reviews as $review)


                        <div class="row">
                            <div class="col-sm-4">
                                <h4>{{ $review->user->name }}</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="rating-tab pull-right">
                                            <input disabled="disabled" checked="{{$review->rate == 1 ? '' : ''}}" type="radio" id="star1" name="rating-01" />
                                            <label for="star1">1 star</label>
                                            <input disabled="disabled" checked="{{$review->rate == 2 ? '' : ''}}" type="radio" id="star2" name="rating-01" />
                                            <label for="star2">2 stars</label>
                                            <input disabled="disabled" checked="{{$review->rate == 3 ? '' : ''}}" type="radio" id="star3" name="rating-01" />
                                            <label for="star3">3 stars</label>
                                            <input disabled="disabled" checked="{{$review->rate == 4 ? '' : ''}}" type="radio" id="star4" name="rating-01" />
                                            <label for="star4">4 stars</label>
                                            <input disabled="disabled" checked="{{$review->rate == 5 ? 'checked' : ''}}" type="radio" id="star5" name="rating-01" />
                                            <label for="star5">5 stars</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p class="date-rate">{{ \Carbon\Carbon::parse($review->created_at)->formatLocalized('%d %b %Y') }} &lpar;
                                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($review->created_at))->diffForHumans()}}
                                            &rpar;
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p>{{ $review->comment }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sec-promotion">
    @if($productsGroup)
    <product-promotion :products_group="{{$productsGroup}}"></product-promotion>
    @endif
</section>
@if(count($product->relatedProducts))
<section class="sec-may-also-like">
    <div class="container">
        <div class="mainhead text-center m-30">
            <h2>{{ __("website.you_may_also_like") }}</h2>
        </div>
        <products-row :products="{{ $product->relatedProducts }}"></products-row>
    </div>

</section>
@endif
@endsection
