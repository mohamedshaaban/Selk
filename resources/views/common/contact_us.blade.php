@extends('layout.app') 
@section('content') @if($settings->banner_sitemap)
<section class="sec-banner">
    <div class="banner">

        <img src="{{ asset('uploads/'.$settings->banner_sitemap) }}" class="img-responsive" alt="banner">

        <h2 class="text-uppercase">{{ __('website.contact_us')}}</h2>
    </div>
</section>
@endif



<section class="sec-contact">

    <div class="container">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}" style="width: 100%;">{{ Session::get('message') }}</p>
        @elseif(Session::has('alert'))
        <p class="alert {{ Session::get('alert-danger', 'alert-danger') }}" style="width: 100%;">{{ Session::get('alert') }}</p>
        @endif
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2 class="text-uppercase">{{ __('website.send_us_message')}}</h2>
                <p class="thanks">{{ __('website.thank_for_reaching_us')}}</p>
            </div>
        </div>
        <form class="row" action="{{ route('website.contact_us.save') }}" method="post">
            @csrf
            <div class="col-md-6 form-colum">
                <input oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Name_label') ])}}')" oninput="this.setCustomValidity('')"
                    type="name" class="form-control" required name="name" placeholder="{{ __('website.Name_label')}}">
                <input type="number" oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.PhoneNumber_label_label') ])}}')"
                    oninput="this.setCustomValidity('')" class="form-control carrer_ph_nu" required name="phone" placeholder="{{ __('website.PhoneNumber_label_label')}}">
            </div>
            <div class="col-md-6 form-colum">
                <input oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Email_label') ])}}')" oninput="this.setCustomValidity('')"
                    type="email" class="form-control" name="email" placeholder="{{ __('website.Email_label')}}">
                <select class="form-control" name="subject" oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Subject') ])}}')"
                    oninput="this.setCustomValidity('')" required>
                            <option value="">{{ __('website.Subject')}}</option>
                            <option value="{{ __('website.general')}}">{{ __('website.general')}}</option>
                            <option value="{{ __('website.problem_in_order')}}">{{ __('website.problem_in_order')}}</option>
                            <option value="{{ __('website.problem_inproduct')}}">{{ __('website.problem_inproduct')}}</option>

                        </select>
            </div>
            <div class="col-xs-12 text-center">
                <textarea oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Message') ])}}')" oninput="this.setCustomValidity('')"
                    class="form-control" required name="message" rows="3" placeholder="{{ __('website.Message')}}"></textarea>
            </div>
            <div class="col-xs-12 text-center form-colum">
                <button oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Message') ])}}')" oninput="this.setCustomValidity('')"
                    type="submit" class="form-control btn text-uppercase form-submit">{{ __('website.Send')}}</button>
            </div>
        </form>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
</section>

<section class="sec-location">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 map">
                <iframe src="{{ $setting->google_map }}" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-xs-6 address">
                <h3 class="text-uppercase">{{ __('website.locations')}}</h3>
                <h4 class="text-uppercase">{{ __('website.address')}}</h4>
                <p>
                    <span>{{ __('website.sellektes_shop')}}</span><br> {{ $setting->address }}
                </p>
                <p><span>{{ __('website.working_hours')}}</span><br> {{ $setting->working_hours }}</p>
                <div>
                    <img src="img/phone-iocn.png" alt=""><span class="phone">{{ $setting->phone  }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection