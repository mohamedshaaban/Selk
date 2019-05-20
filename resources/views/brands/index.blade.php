@extends('layout.app')
@section('content')
@if($settings->banner_characters_listing)
<section class="sec-banner">
    <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_characters_listing) }}" class="img-responsive" alt="banner">

              <h2 class="text-uppercase">{{ __("website.brands") }} </h2>

    </div>
</section>
@endif
<div class="sec-crumb">
    <div class="container">
        <ol class="breadcrumb">
                <li><a href="/">{{ __('website.Home_label') }}</a></li>
            <li class="active">{{ __('website.brands_label') }}</li>
        </ol>
    </div>
</div>
<section class="pb-45">
    <brands :brands_list="{{ $brands }}"></brands>
</section>
@endsection
