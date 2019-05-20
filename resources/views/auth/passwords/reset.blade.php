@extends('layout.app')

@section('content')
@if($settings->banner_login)
      <section class="sec-banner">
          <div class="banner">


              <img src="{{ asset('uploads/'.$settings->banner_login) }}" class="img-responsive" alt="banner">

              <h2 class="text-uppercase">Forgot Your <span class="text-uppercase">Password?</span></h2>
          </div>
      </section>
@endif
      <div class="sec-crumb">
          <div class="container">
              <ol class="breadcrumb">
                    <li><a href="/">{{ __('website.Home_label') }}</a></li>
                  <li class="active">{{ __('website.forgot_password') }}</li>
              </ol>
          </div>
      </div>
<section class="sec-forgot">
<div class="container">


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}" class="row">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                            <div class="col-xs-9">
                                <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif


                            <div class="col-xs-9">
                                <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-xs-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                            </div>

 <div class="col-xs-12">
                      <button type="submit" class="form-control btn form-submit text-uppercase">{{ __('Reset Password') }}</button>
                  </div>

                    </form>
                </div>
            </div>
</section>

@endsection
