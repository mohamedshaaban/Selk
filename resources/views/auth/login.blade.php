@extends('layout.app')
@section('content')
@if($settings->banner_login)
    <section class="sec-banner">
      <div class="banner">
          
        <img src="{{ asset('uploads/'.$settings->banner_login) }}" class="img-responsive" alt="banner">
        
        <h2 class="text-uppercase">{{__('website.customer_label')}}<span class="text-uppercase">{{__('website.login_label')}}</span></h2>
      </div>
    </section>
@endif
  <section class="ptb-30">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="col-md-6 login pr-20">
                    <h3>{{__('website.have_acount_label') }}
                    </h3>
                    <p>{{__('website.signinspeed_label')}}</p>
                   
                    <div class="alert alert-danger alert-dismissible errorlogin" style="display: none;" role="alert">
                <strong>{{__('website.Invalid credentials')}}</strong>
              </div>
                <form id="formLogin"  class="formLogin">

                    <input type="hidden" name="cart" value="{{  request()->has('cart') }} " />


                  @csrf
                  <div class="alert alert-danger alert-dismissible errorloginemail" style="display: none;" role="alert">
                <strong>{{__('website.Invalid email')}}</strong>
              </div>
                  <input class="inpt" type="email" name="email" placeholder="{{__('website.email_label')}}">
                  <div class="alert alert-danger alert-dismissible errorloginpassword" style="display: none;" role="alert">
                <strong>{{__('website.Invalid password')}}</strong>
              </div>
                  <input class="inpt" type="password" name="password" placeholder="{{__('website.Password_label')}}">
              <button class="button-main btn_login" id="btn_login" type="button">{{__('website.submit')}}</button>
              </form>
                    <div class="check_box_here">
                      <span class="check">
                        <input id="rem" value="1" name="" type="checkbox">
                        <label for="rem"></label>
                      </span>
                      <label for="rem">{{__('website.Remember')}}</label>
                    </div>
                    <a class="frgt" href="{{ route('password.request') }}">{{__('website.Forgot Password')}}?</a>
                    <div class="rlt">
                        <div class="text-center line-mdl">
                  <p class="or">{{__('website.OR')}}</p>
                  <div class="text-center pad">
                    <a href="{{ route('sociallogin',['facebook']) }}">
                      <img src="/img/fb-red.png" alt="">
                    </a>
                    <a href="{{ route('sociallogin',['twitter']) }}">
                      <img src="/img/twit-red.png" alt="">
                    </a>
                    <a href="{{ route('sociallogin',['google']) }}">
                      <img src="/img/insta-red.png" alt="">
                    </a>
                  </div>
                </div>
                       
                    </div>
                  </div>
                  <div class="col-md-6 login pl-20">
                    <h3>{{__('website.new_sellectks_label')}}</h3>
              <p class="">{{__('website.login_text_label')}} </p>
              <button type="button" style="margin-top: 81.5px;" class="button-main mdt-signup mt-xp" data-toggle="modal" data-target="#sign-up" data-dismiss="modal">{{__('website.Sign up')}}</button>
                    <div class="rlt">
                      <div class="text-center line-mdl">
                  <p class="or">{{__('website.OR')}}</p>
                  <div class="text-center pad">
                    <a href="{{ route('sociallogin',['facebook']) }}">
                      <img src="/img/fb-red.png" alt="">
                    </a>
                    <a href="{{ route('sociallogin',['twitter']) }}">
                      <img src="/img/twit-red.png" alt="">
                    </a>
                    <a href="{{ route('sociallogin',['google']) }}">
                      <img src="/img/insta-red.png" alt="">
                    </a>
                  </div>
                </div>
                      
                    </div>
                  </div>
                </div>

          </div>
        </div>
  </section>
@endsection
