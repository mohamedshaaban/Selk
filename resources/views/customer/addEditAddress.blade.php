@extends('layout.app')
@section('content')
@if($settings->banner_editaddresss)
    <section class="sec-banner">
        <div class="banner">

              <img src="{{ asset('uploads/'.$settings->banner_editaddresss) }}" class="img-responsive" alt="banner">


            <h2 class="text-uppercase">{{ __('website.Add New') }}<span class="text-uppercase"> {{ __('website.Address') }}</span></h2>
        </div>
    </section>
@endif
    <div class="sec-crumb forgot-pass">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">{{ __('website.home_label') }}</a></li>
                <li><a href="{{ route('customer.address_book') }}">{{ __('website.address_book_label') }}</a></li>
                <li class="active">{{ __('website.add_address') }}</li>
            </ol>
        </div>
    </div>

    <section class="my-profile">
      <div class="container">


           @include('customer.includes.profile_menu')

<div class="col-md-9">
 <div class="small-h8">
  <h3 class="col-md-6 col-sm-6 col-xs-6 lft">{{ __('website.add_address') }}</h3>
  <!-- <a  class="col-md-6 col-sm-6 col-xs-6 rit remove-disabled">Manage Account Information</a>    -->
 </div>
    <form action="{{ route('customer.saveAddress')}}" method="post">
        @csrf
        @if(!$create)
        <input type="hidden" name="id" value="{{ $address['id'] }}"/>
        @endif
 <div class="register_box mt-20 full-width">

        <div class="row">
          <div class="col-md-6 col-lg-6">
              <select class="inpt" placeholder="{{ __("website.mr") }}" name="user_label" value="{{ $address['user_label'] }}" required="" id="user_label">
                    <option value="mr">{{ __("website.mr") }}</option>
                    <option value="mrs">{{ __("website.mrs") }}</option>
                  </select>
          </div>

          <div class="col-lg-6 col-md-6">
              <input class="inpt"  type="text" name="first_name" required="" value="{{ $address['first_name'] }}" placeholder="{{ __("website.first_name_label") }}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
              <input class="inpt" type="text" name="last_name" required="" value="{{ $address['last_name'] }}"  placeholder="{{ __("website.last_name_label") }}">
          </div>
            <div class="col-lg-6 col-md-6">
                <input class="inpt" type="text"  name="address_type" value="{{ $address['address_type'] }}" required="" placeholder="{{ __("website.address_type") }}">

            </div>

            <!-- /.col-lg-6 -->
            <div class="col-lg-6 col-md-6">
                <select class="inpt country" name="governorate_id" required="" id="governorate_id">
                    <option value="">{{ __("website.country_label") }}</option>
                    @foreach($countries as $country)
                        <option @if($address['governorate_id']==$country->id) selected @endif value="{{ $country->id }}">{{ $country->title }}</option>
                    @endforeach


                </select>
            </div>

            <!-- /.col-lg-6 -->
            <div class="col-lg-6 col-md-6">
                <select class="inpt province" name="province" id="province" required="">
                    <option value="">{{ __("website.territory_label") }}</option>
                    @foreach($provience as $provienc)
                        <option @if(isset($address['provience'])) @if($address['provience']['id']==$provienc->id) selected @endif @endif value="{{ $provienc->id }}">{{ $provienc->title }}</option>
                    @endforeach


                </select>
            </div>
            <div class="col-lg-6 col-md-6">

                <select class="inpt city" name="city" required="" id="city">
                    <option value="">{{ __("website.city_req") }}</option>
                    @foreach($cities as $city)
                        <option @if($address['city']==$city->title_en) selected @endif value="{{ $city->title_en }}">{{ $city->title }}</option>
                    @endforeach


                </select>
            </div>
                                                    <!-- /.col-lg-6 -->
            <div class="col-lg-6 col-md-6">
                <input class="inpt" type="text" name="post_code" value="{{ $address['post_code'] }}" required="" placeholder="{{ __("website.postcode_labelreq") }}">
            </div>
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="text" name="first_address" value="{{ $address['first_address'] }}" placeholder="{{ __("website.addressline1") }}">
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input class="inpt" type="text" name="second_address" value="{{ $address['second_address'] }}" placeholder="{{ __("website.addressline2") }}">
                          </div>



          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
              <!-- d-inline-flex
                <input class="inpt ctr-code" type="text"  placeholder="code" >

            <input class="inpt num-pk" type="text" placeholder="Mobile Number"> -->
            <select class="inpt country-code">
              <option>
                <img src="/images/icons/tracking.png" alt="">
                +965
              </option>
            </select>
              <input class="inpt ph-no" type="number" name="phone_no" required="" value="{{ $address['phone_no'] }}" placeholder="{{ __("website.phone_label") }}">
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
              <!--  d-inline-flex
                <input class="inpt ctr-code" type="text" placeholder="code">

            <input class="inpt num-pk" type="text" placeholder="Phone Number"> -->
            <select class="inpt country-code">
              <option>
                <img src="/images/icons/tracking.png" alt="">
                +965
              </option>
            </select>
              <input class="inpt ph-no" type="number" name="mobile_no" value="{{ $address['mobile_no'] }}" placeholder="{{ __("website.mobile_label") }}">
          </div>

          <!-- /.col-lg-6 -->
          <div class="col-lg-6 col-md-6">
              <div class="check_box_here"> <span class="check">
                      <input id="shipadd" class="chg-psw" name="default_shipping" @if($address['is_default'] ==1 ) checked @endif type="checkbox">
                <label for="shipadd"></label>
                </span>
                <label for="shipadd">{{ __('website.make_default_address') }}</label>
              </div>
              <!-- /.check_box_here -->
            </div>



        </div>
        <!-- /.row -->




        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-25 clear col-md-offset-3">
            <button class="button-main" type="submit">{{ __('website.save') }}</button>
        </div>



      </div>
    </form>
</div>
        </div>
    </section>

@endsection
