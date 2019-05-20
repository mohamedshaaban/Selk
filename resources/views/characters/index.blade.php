@extends('layout.app')
@section('content')
@if($settings->banner_characters_listing)
<section class="sec-banner">
    <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_characters_listing) }}" class="img-responsive" alt="banner">


              <h2 class="text-uppercase">{{ __("website.characters") }} </h2>
    </div>
</section>
 @endif
<div class="sec-crumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ url('/')}}">{{ __('website.home_label')}}</a></li>
            <li class="active">{{ __('website.characters_label')}}</li>
        </ol>
    </div>
</div>
<section class="pb-45">
   <characters :characters_list="{{ $characters }}"></characters>
</section>
@endsection
