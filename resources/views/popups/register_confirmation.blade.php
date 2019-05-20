  <div id="confirmation" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="col-md-12">
              <div class="col-md-12 login">
                <div class="mainhead text-center m-30 mt-0">
                  <h2>{{ __('website.registration_confirmation_label') }}</h2>
                </div>
                  <form id="verify_account_form">
                      @csrf
                <div class="">
                    <div class="text-center">
                        <img src="/img/selctx.png" alt="">
                        <p class="cnfrm">{{ __('website.thank_you_label') }} <br>
                          {{ __('website.for_registering_label') }}<span> Sellektes</span>{{ __('website.online_store_label') }} <br>
                          {{ __('website.check_email_label') }}</p>
                                          </div>
                    <div id="verfiy_errors" style="display: none ; color: red">
                        <p>{{ __('website.invalid_code_label') }}</p>
                      </div>
                                          <div class="col-lg-8 col-md-8  mt-25 clear col-md-offset-2 confirm-input">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input class="inpt" maxlength="1" name="code[]" type="text" placeholder="*">
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input class="inpt" maxlength="1" name="code[]" type="text" placeholder="*">
                                              </div>
                                              <div class="col-md-2 col-sm-2 col-xs-2">
                                                  <input class="inpt" maxlength="1" name="code[]" type="text" placeholder="*">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <input class="inpt" maxlength="1" name="code[]" type="text" placeholder="*">
                                                  </div>
                                                  <div class="col-md-2 col-sm-2 col-xs-2">
                                                      <input class="inpt" maxlength="1" name="code[]" type="text" placeholder="*">
                                                  </div>
                                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                                        <input class="inpt" maxlength="1"name="code[]"  type="text" placeholder="*">
                                                  </div>
                                          </div>
                    <div class="register_box full-width">
                        <div class="col-lg-8 col-md-8  mt-25 clear col-md-offset-2">
                            <button class="button-main" id="verify_account" type="button">{{ __('website.Verify_label') }}</button>
                            <a href="#" onclick="resend_code()" class="resend">{{ __('website.not_received_code_label') }}<span>{{ __('website.resend_code_label') }}</span></a>
                        </div>
                     </div>
                    <!-- /.register_box --> 
                  </div>
                  </form>
              </div>   
            </div>
          </div>
        </div>
      </div>
  </div>
