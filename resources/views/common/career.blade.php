@extends('layout.app')
@section('content')



    @if($settings->banner_career)
        <section class="sec-banner">
            <div class="banner">
                <img src="{{ asset('uploads/'.$settings->banner_career) }}" class="img-responsive" alt="banner">
                <h2 class="text-uppercase">{{trans('website.career')}}</h2>
            </div>
        </section>
    @endif

    <section class="sec-career">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2 class="text-uppercase">{{trans('website.apply_job')}}</h2>
                    <blockquote class="blockquote">{{trans('website.love_sellekts')}}.</blockquote>
                    <h3>{!! __('website.interested') !!}</h3>
                    </div>
            </div>

            @if(\Session::has('message'))
                <div class="alert alert-success">
                    {{ \Session::get('message') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('website.career.save')}}" method="post" enctype="multipart/form-data" class="row">
                @csrf
                <div class="col-sm-6 form-colum">
                    <input 
                    required
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.first_name_label') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="text" name="first_name"  value="{{\Illuminate\Support\Facades\Input::old('first_name')}}" class="form-control"
                           placeholder="{{__('website.first_name_label')}}">
                </div>
                <div class="col-sm-6 form-colum">
                    <input 
                    required
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.last_name_label') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="text" name="last_name" class="form-control" value="{{\Illuminate\Support\Facades\Input::old('last_name')}}" placeholder="{{__('website.last_name_label')}}">
                </div>
                <div class="col-sm-6 form-colum">
                    <input
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.email_label') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="email" name="email" required class="form-control" value="{{\Illuminate\Support\Facades\Input::old('email')}}" placeholder="{{__('website.email_label')}}">
                </div>
                <div class="col-sm-6 form-colum">
                    <input 
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.tel') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="number" name="tel" required class="form-control carrer_ph_nu" value="{{\Illuminate\Support\Facades\Input::old('tel')}}" placeholder="{{__('website.tel')}}l">
                </div>
                <div class="col-sm-6 form-colum">
                    <input 
                    required
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.apply_job') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="text" name="position" value="{{\Illuminate\Support\Facades\Input::old('position')}}" 
                    class="form-control"
                    placeholder="{{__('website.apply_job')}}">
                </div>
                <div class="col-sm-6 form-colum">
                    <select name="nationality" class="form-control"
                    required
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.Nationality') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    >
                        <option value="">{{trans('website.Nationality')}}</option>

                        @foreach($countries as $country)
                            <option @if( \Illuminate\Support\Facades\Input::old('nationality') == $country->id ) selected= 'selected'  @endif value="{{$country->id}}">{{$country->title}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="col-sm-6 form-colum">
                    <input type="text" class="form-control" placeholder="Interested job position">
                </div> -->
                <div class="col-sm-6 form-colum">
                    <input 
                    oninvalid="this.setCustomValidity('{{__('validation.required' ,['attribute' => __('website.uploadcv') ])}}')"   
                    oninput="this.setCustomValidity('')"                
                    type="file" name="attachment" required class="form-control upld">
                    <input disabled class="form-control abs-upld" placeholder="{{__('website.uploadcv')}}">
                </div>
                <div class="col-xs-12 text-center">
                    <button type="submit"
                            class="form-control btn text-uppercase form-submit">{{__('website.submit')}}</button>
                </div>
            </form>
        </div>
    </section>


@endsection
