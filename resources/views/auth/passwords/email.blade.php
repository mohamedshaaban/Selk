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

                    <form method="POST" action="{{ route('password.email') }}" class="row">
                        @csrf
                        <div class="col-xs-12">
                                              <p>{{ __('website.enter_email_forgot') }}</p>
                                          </div>


                            <div class="col-xs-9">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                    <div class="col-xs-12">
                      <button type="submit" class="form-control btn form-submit text-uppercase">{{ __('Send Password Reset Link') }}</button>
                  </div>

                    </form>

</div>
</div>
</section>
@endsection
