@extends('layout.app')
@section('content')
   
  @if($settings->banner_user_account)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_user_account) }}" class="img-responsive" alt="banner">


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

<div class="col-md-9">
 <div class="small-h8">
  <h3 class="col-md-6 col-sm-6 col-xs-6 lft">{{ __('website.account_info_label') }}</h3>
  <a  class="col-md-6 col-sm-6 col-xs-6 rit remove-disabled">{{ __('website.manage_account_info_label')}}</a>
 </div>
    <form action="{{ route('customer.update_profile')}}" method="post" >
        @csrf
 <div class="register_box mt-20 full-width">

        <div class="row">
          <div class="col-lg-6 col-md-6">
            <input class="inpt" disabled="disabled"  name="first_name" id="first_name" type="text" value="{{ $user->first_name }}" placeholder="{{__('website.first_name_label')}}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
            <input class="inpt" disabled="disabled" name="last_name" id="last_name" type="text" value="{{ $user->last_name }}" placeholder="{{__('website.last_name_label')}}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
            <input class="inpt" type="email" name="email"  disabled="disabled" value="{{ $user->email }}" placeholder="{{__('website.email_label')}}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
            <input class="inpt country-phone" type="tel" disabled="disabled" name="phone" id="phone" value="{{ $user->phone }}" placeholder="{{__('website.phone_label')}}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
              <input class="inpt aftr-edt " type="password" name="oldpassword" id="oldpassword" required="" placeholder="{{__('website.your_password_label')}}">
          </div>
          <div class="col-lg-6 col-md-6">
              <input class="inpt Change-pswd" type="password" type="password" name="password" id="password" placeholder="{{__('website.Password_label')}}">
          </div>
          <div class="col-lg-6 col-md-6">
              <input class="inpt Change-pswd" type="password" name="password_confirmation" id="password_confirmation" placeholder="{{__('website.confirm_password_label')}}">
          </div>
          <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->

        <div class="full-width aftr-edt">
          <div class="check_box_here"> <span class="check">
            <input id="pre" class="chg-psw" value="1" name="chgPwdReq" type="checkbox">
            <label for="pre"></label>
            </span>
            <label for="pre">{{__('website.change_password_label')}}</label>
          </div>
          <!-- /.check_box_here -->
        </div>
        <!-- /.full-width -->


          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-25 clear col-md-offset-3">
              <button class="button-main aftr-edt" type="submit" >{{__('website.submit_label')}}</button>
          </div>


      </div>
    </form>
</div>
        </div>
    </section>

@endsection
@section('scripts')


@stop
