@extends('layout.app') 
@section('content')

    @if($settings->banner_cart)
        <section class="sec-banner">
            <div class="banner">

                <img src="{{ asset('uploads/'.$settings->banner_cart) }}" class="img-responsive" alt="banner">


                <h2 class="text-uppercase">{{ $page->name }}</h2>
            </div>
        </section>
    @endif
 
    <section class="sec-aboutus">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-justify">



{!! $page->description !!}
                </div>
                
            </div>
        </div>
    </section>

@endsection
