@extends('layout.app')
@section('content')
<section class="sec-banner">
    <div class="banner">
              @if($settings->banner_categories_listing)
              <img src="{{ asset('uploads/'.$settings->banner_categories_listing) }}" class="img-responsive" alt="banner">
              @endif

              <h2 class="text-uppercase">{{ __("website.categories") }} </h2>
    </div>
</section>
<div class="sec-crumb">
    <div class="container">
        <ol class="breadcrumb">
                <li><a href="/">{{ __('website.Home_label') }}</a></li>
            <li class="active">{{ __('website.categories_label') }}</li>

        </ol>
    </div>
</div>
<section class="pb-45 upcoming-events">
    <categories :categories_list="{{ $categories }}"></categories>
</section>
@endsection
