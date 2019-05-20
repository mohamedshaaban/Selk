@extends('layout.app')
@section('content')
@if($settings->banner_faq)
    <section class="sec-banner">
        <div class="banner">
            <img src="{{ asset('uploads/'.$settings->banner_faq) }}" class="img-responsive" alt="banner">
            <h2 class="text-uppercase">{{ __("website.faq") }}</h2>
        </div>
    </section>
@endif
    <section class="sec-faq">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="wrapper">
                        <div class="faq">
                            @foreach($faqs as $faq)
                            <div class="question">
                                <input id="quest{{ $faq->id }}" type="radio" name="tabs2">
                                <label for="quest{{ $faq->id }}">{{ $faq->question }}</label>
                                <div class="tab-content">
                                    <p>{{ $faq->answer }}</p>
                                </div>
                            </div>
                       @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
