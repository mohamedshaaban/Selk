@extends('layout.app')
@section('content') @if($settings->banner_notification_setting)
<section class="sec-banner">
    <div class="banner">

        <img src="{{ asset('uploads/'.$settings->banner_notification_setting) }}" class="img-responsive" alt="banner">

        <h2 class="text-uppercase">{{ __('website.my_label')}} <span class="text-uppercase">{{ __('website.profile_label')}}</span></h2>
    </div>
</section>
@endif
<div class="sec-crumb forgot-pass">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">{{ __('website.home_label')}}</a></li>
            <li><a href="{{ route('customer.my_profile') }}">{{ __('website.my_account_label_label')}}</a></li>
            <li class="active">{{ __('website.my_profile_label')}}</li>
        </ol>
    </div>
</div>

<section class="my-profile">
    <div class="container">
    @include('customer.includes.profile_menu')
        <form method="post" action="{{ route('customer.save_shop_by_interest')}}">
            @csrf
            <div class="col-md-9">
                <div class="small-h8 mjka mt-25">
                    <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.categories_label') }}</b></h3>
                </div>
                <div class="gray_box full-width new_tab_section">
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                        @foreach ($categories as $category )
                        <div class="left_div sm_chnge">
                            <div class="radio_left">
                                <input id="r51" value="{{ $category->id}}" {{ in_array($category->id,$userCategories) ? 'checked'
                                : ''}} name="categories[{{$category->id}}]" type="checkbox">
                                <label for="r51"></label>
                            </div>{{ $category->name_en }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="small-h8 mjka mt-25">
                    <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.brand_label') }}</b></h3>
                </div>
                <div class="gray_box full-width new_tab_section">
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                        @foreach ($brands as $brand )
                        <div class="left_div sm_chnge">
                            <div class="radio_left">
                                <input id="r51" value="{{ $brand->id}}" {{ in_array($brand->id,$userBrands) ? 'checked' :
                                ''}} name="brands[{{$brand->id}}]" type="checkbox">
                                <label for="r51"></label>
                            </div>{{ $brand->name_en }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="small-h8 mjka mt-25">
                    <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.characters_label') }}</b></h3>
                </div>
                <div class="gray_box full-width new_tab_section">
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                        @foreach ($characters as $character )
                        <div class="left_div sm_chnge">
                            <div class="radio_left">
                                <input id="r51" value="{{ $character->id }}" {{ in_array($character->id,$userCharacters)
                                ? 'checked' : ''}} name="characters[{{$character->id}}]" type="checkbox">
                                <label for="r51"></label>
                            </div>{{ $character->name_en }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9 offset-md-3">
                <div class="small-h8 mjka mt-25">
                    <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.tags_label') }}</b></h3>
                </div>
                <div class="gray_box full-width new_tab_section">
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                        @foreach ($tags as $tag )
                        <div class="left_div sm_chnge">
                            <div class="radio_left">
                                <input id="r51" {{ in_array($tag->id,$userTags) ? 'checked' : ''}} value="{{$tag->id}}" name="tags[{{$tag->id}}]"
                                type="checkbox">
                                <label for="r51"></label>
                            </div>{{ $tag->name_en }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="register_box mt-20 full-width">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-25 clear col-md-offset-3"><input type="submit" class="button-main p5"></a>
                    </div>
                </div>
            </div>
        </form>



</section>
@endsection
