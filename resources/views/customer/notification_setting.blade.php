@extends('layout.app')
@section('content')

@if($settings->banner_notification_setting)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_notification_setting) }}" class="img-responsive" alt="banner">

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
 <div class="small-h8 mjka">
   <p class="fs-16">{{ __('website.notification_text')}}</p>
  <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.email_notification')}}</b></h3>
  <!-- <a  class="col-md-6 col-sm-6 col-xs-6 rit remove-disabled">Manage Account Information</a>    -->
 </div>
 <div class="gray_box full-width new_tab_section">
    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                  <div class="left_div sm_chnge">
                    <div class="radio_left">
                        <input id="r5" value="1" name="email_notification" onclick="updateNotifiSetting('email',this.value)" @if($user->email_notification == 1 ) checked="checked" @endif type="radio">
                      <label for="r5"></label>
                    </div>
                    <!-- /.radio_left -->
                    <label for="r5">{{ __('website.yes')}}</label>
                  </div>
                  <!-- /.left_div -->

                  <div class="left_div sm_chnge">
                    <div class="radio_left">
                        <input id="r6" value="0" name="email_notification" onclick="updateNotifiSetting('email',this.value)" @if($user->email_notification == 0 ) checked="checked" @endif type="radio">
                      <label for="r6"></label>
                    </div>
                    <!-- /.radio_left -->
                    <label for="r6">{{ __('website.no')}}</label>
                  </div>
                  <!-- /.left_div -->
                </div><!-- /.col-lg-5 -->
  </div>
  <div class="small-h8 mjka mt-25">
     <h3 class="col-md-6 col-sm-6 col-xs-6 lft"><b>{{ __('website.sms_notification')}}</b></h3>
     <!-- <a  class="col-md-6 col-sm-6 col-xs-6 rit remove-disabled">Manage Account Information</a>    -->
    </div>
    <div class="gray_box full-width new_tab_section">
       <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 fl_width_562 custom_radio_button">
                     <div class="left_div sm_chnge">
                       <div class="radio_left">
                           <input id="r51" value="1" name="sms_notification" onclick="updateNotifiSetting('sms',this.value)" @if($user->sms_notification == 1 ) checked="checked" @endif type="radio">
                         <label for="r51"></label>
                       </div>
                       <!-- /.radio_left -->
                       <label for="r51">{{ __('website.yes')}}</label>
                     </div>
                     <!-- /.left_div -->

                     <div class="left_div sm_chnge">
                       <div class="radio_left">
                           <input id="r61" value="0" name="sms_notification" onclick="updateNotifiSetting('sms',this.value)" @if($user->sms_notification == 0 ) checked="checked" @endif type="radio">
                         <label for="r61"></label>
                       </div>
                       <!-- /.radio_left -->
                       <label for="r61">{{ __('website.no')}}</label>
                     </div>
                     <!-- /.left_div -->
                   </div><!-- /.col-lg-5 -->
     </div>
</div>
        </div>

    </section>

@endsection

