<div id="login-reg" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="col-md-12">
          <div class="col-md-6 login">
            <h3>{{__('website.have_acount_label') }}
            </h3>
            <p>{{__('website.signinspeed_label')}}</p>
            <div class="list-inline mp-0">

            </div>
            <div class="alert alert-danger alert-dismissible errorlogin" style="display: none;" role="alert">
              <strong>{{__('website.Invalid credentials')}}</strong>
            </div>
            <form id="formLogin" class="formLogin">
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
          <div class="col-md-6 login">
            <h3>{{__('website.new_sellectks_label')}}</h3>
            <p class="mitst">{{__('website.login_text_label')}} </p>
            <button type="button" class="button-main mdt-signup" data-toggle="modal" data-target="#sign-up" data-dismiss="modal">{{__('website.Sign up')}}</button>
            <div class="rlt">
              <div class="text-center line-mdl">
                <p class="or">{{__('website.OR')}} </p>
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
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="gnk">
              <h3 class="keepi">{{__('website.Keep_in_mind_label')}}</h3>
            </div>
            <!-- <div class="clearfix">&nbsp;</div> -->
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 fl_width_562">
            <h5>
              <img src="/img/change-psd.png" alt="img" class="mCS_img_loaded">
              <div class="clear"></div>
              {{__('website.change_your_password_label')}} </h5>
          </div>
          <!-- /.col-lg-6 -->

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 fl_width_562">
            <h5>
              <img src="/img/avoid.png" alt="img" class="mCS_img_loaded">
              <div class="clear"></div>
              {{__('website.avoid_reuse_password_label')}}</h5>
          </div>
          <!-- /.col-lg-6 -->

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 fl_width_562">
            <h5>
              <img src="/img/pswd.png" alt="img" class="mCS_img_loaded">
              <div class="clear"></div>
              {{__('website.use_complex_label')}}</h5>
          </div>
          <!-- /.col-lg-6 -->

        </div>

      </div>
    </div>
  </div>
</div>