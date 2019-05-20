@extends('layout.app') 
@section('content') @if($settings->banner_order_history)
<section class="sec-banner">
    <div class="banner">

        <img src="{{ asset('uploads/'.$settings->banner_order_history) }}" class="img-responsive" alt="banner">

        <h2 class="text-uppercase">{{ __('website.My Order')}} <span class="text-uppercase">{{ __('website.History')}}</span></h2>
    </div>
</section>
@endif
<div class="sec-crumb forgot-pass">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">{{ __('website.home_label')}}</a></li>
            <li><a href="{{ route('customer.my_profile') }}">{{ __('website.my_account_label_label')}}</a></li>
            <li class="active">{{ __('website.track_order_label')}}</li>
        </ol>
    </div>
</div>
<section class="sec-forgot">
    <div class="container">
        <form class="row">
            <div class="col-md-12 col-xs-12">
                <p>{{ __('website.need_track_orders')}}
                </p>
            </div>
            <div class="col-md-12 col-xs-12">
                <input 
                name="tracking_number" 
                type="text" 
                class="inpt"
                value="{{ old('tracking_number' , request('tracking_number'))}}"
                placeholder="{{ __('website.track_number')}}">
            </div>
            @if ($errors->has('tracking_number'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('tracking_number') }}</strong>
            </span> @endif
            <div class="col-md-12 col-xs-12">
                <button type="submit" class="form-control btn form-submit text-uppercase">{{ __('website.Track_Order')}}</button>
                <a class="go-to" href="{{ route('customer.order_history') }}">{{ __('website.goto_order_label')}}</a>
            </div>
        </form>
        
        @if(count($data) && !isset($data->Status->Condition))
        <div class="row">
            <div class="col-md-6">
                <div class="gray-bg">
                    <div class="">
                        <p class="addt">{{ __('website.DELIVERY DATE')}}</p>
                        <h3 class="deliv-day">MONDAY
                            <br><span>JULY 3</span></h3>
                        <p class="status-deliv">{{ __('website.Succesfully_Delivered')}}</p>
                        <div class="track-num">
                            <img src="img/dhla.png" alt="">
                            <p class="track-h8">{{ __('website.track_number')}}
                                <br><span>{{ request('tracking_number') ? request('tracking_number') : ''}}</span></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="gray-bg">
                    <div class="">
                        <p class="addt">YOUR DELIVERY STATUS</p>
                        <p class="status-deliv nomarp">Succesfully Delivered</p>
                        @php($data = is_array($data) ? $data : [$data])
                        @foreach ($data as $trackInfo) {{-- {{ dd($trackInfo->ShipmentInfo->ShipmentDate)}} --}}
                        
                        <div class="procedure-order">
                            <p class="track-time">{{ date('Y-m-d H:i:m a' , strtotime($trackInfo->ShipmentInfo->ShipmentDate)) }}</p>
                            <p class="track-state">{{ $trackInfo->Status->ActionStatus}}</p>
                            <p class="track-reg">{{$trackInfo->ShipmentInfo->DestinationServiceArea->Description}}</p>
                        </div>
                        @endforeach {{--
                        <div class="procedure-order">
                            <p class="track-time">JUL 05, 04:50 PM</p>
                            <p class="track-state">Delivered - Signed for by</p>
                            <p class="track-reg">HANGARES - MEXICO</p>
                        </div>
                        <div class="procedure-order">
                            <p class="track-time">JUL 05, 04:50 PM</p>
                            <p class="track-state">Delivered - Signed for by</p>
                            <p class="track-reg">HANGARES - MEXICO</p>
                        </div> --}}

                    </div>
                </div>
            </div>

        </div>
        @elseif(isset($data->Status->Condition))
        <p>{{ $data->Status->Condition->ConditionData }}</p>
        @endif
    </div>
</section>
@endsection