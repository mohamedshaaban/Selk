 <div id="sign-up" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <form id="register_form">
              @csrf
          <div class="col-md-12">
            <div class="col-md-12 login">
              <div class="mainhead text-center m-30">
                <h2>{{__('website.sign_up_label')}}</h2>
              </div>
              <div class="gnk">
                <p class="psing">{{__('website.new_to_sellects_label')}}</p>
              </div>
              <div class="">
                  <div class="register_box full-width">
                      <div id="register_errors">
                      </div>
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="text"
                           name="first_name" id="first_name" 
                           placeholder="{{__('website.first_name_label')}}" 
                           required=""
                           >
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="text" name="last_name" id="last_name" placeholder="{{__('website.last_name_label')}}" required="">
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="email" name="email" value="" id="email" placeholder="{{__('website.email_label')}}" required="">
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6 col-md-6">
                          <select class="inpt country-code" name="country_code">
                              <option value="+965">
                            <img src="images/icons/tracking.png" alt="">
                            +965
                          </option>
                        </select>
                          <input class="inpt ph-no" type="number" name="phone" id="phone" placeholder="{{__('website.phone_label')}}" required="">
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="password" name="password" id="password" placeholder="{{__('website.Password_label')}}" required="">
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6 col-md-6">
                          <input class="inpt" type="password" name="password_confirmation" id="password_confirmation" placeholder="{{__('website.confirm_password_label')}}" required="">
                      </div>
                      <!-- /.col-lg-6 --> 
                    </div>
                    <!-- /.row -->
                    
                    <div class="full-width">
                      <div class="check_box_here"> <span class="check">
                              <input id="pre" value="1" name="accept_terms" checked  type="checkbox">
                              <label for="pre" id="prelabel"></label>
                        </span>
                        <label for="pre">{{__('website.agree_label')}} <a href="terms.html">{{__('website.terms_conditions_label')}}</a> </label>
                      </div>
                      <!-- /.check_box_here --> 
                    </div>
                    <!-- /.full-width -->
                    
                   
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-25 clear col-md-offset-3">
                          <button class="button-main" type="button"  id="btn_register" >{{__('website.submit_label')}}</button>
                          <button class="button-main" type="button" data-toggle="modal" data-target="#confirmation" id="next_register_step" style="display: none" data-dismiss="modal">{{__('website.submit_label')}}</button>
                      </div>

                   
                  </div>
                  <!-- /.register_box --> 
                </div>

            </div>

          </div>
          </form>

        </div>
      </div>
    </div>
  </div>