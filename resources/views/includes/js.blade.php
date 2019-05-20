<script>
    $( document ).ready(function() {

    $(".lc-1hfc2ps").attr("src","/img/chat-icn.png");
    });
    $('.next-date').change(function() {
		$('.absolute-date').val($(this).val());
	});
    $('#btn_register').click(function()
    {
        
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        var form = $("#register_form");
        form.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: password
                },
              
            }
        });
        if (form.valid() == false) {
            return;
        }

        var $data = $("#register_form").serializeArray();

        $.ajax({
            method: "post",
            url: "/register",
            data: $.param($data),
            success: function(result) {
                if (result.status == "true") {
                    $('#register_form').find('input').val('');
                    $("#next_register_step").click();

                } else {
                    $("#register_errors").html(result.errors);
                }
                return;
            }
        });
    });
    $("#verify_account").click(function() {
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        var form = $("#verify_account_form");
        form.validate();
        if (form.valid() == false) {
            return;
        }

        var $data = $("#verify_account_form").serializeArray();
        $.ajax({
            method: "post",
            url: "/verify_account",
            data: $.param($data),
            success: function(result) {
                if (result == "1") {
                    window.location.href = "/login";
                } else {
                    $("#verfiy_errors").show();
                }
                return;
            }
        });
    });

    $(".btn_login").click(function() {
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        var form = $("#formLogin");
        form.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            }
        });
      
        if (form.valid() == false) {
         
            return;
        }

        var $data = form
            .parent()
            .find(".formLogin")
            .serializeArray();
        $.ajax({
            method: "post",
            url: "/ajaxlogin",
            data: $.param($data),
            success: function(result) {
                if (result.logged == true) {

                    if(result.cart == 1)
                    {
                        // Simulate a mouse click:
                        window.location.href = "/checkout";
                    }
                    else
                    {
                        location.reload();
                    }

                } else {
                    if (result.code == "1") {
                        $(".errorloginemail").show();
                        $(".errorloginpassword").hide();
                    } else {
                        $(".errorloginpassword").show();
                        $(".errorloginemail").hide();
                    }
                }
                return;
            }
        });
    });
    function resend_code() {
        var email = $("#email").val();
        $.ajax({
            method: "get",
            url: "/resend_code",
            email: email,
            success: function(result) {}
        });
    }
    $("#amount").change(function() {
        var amount = $(this).val();

        $("#cardPrice").html(amount);
    });
    $(".remove-disabled").click(function(q) {
        q.stopPropagation();
        $(".inpt").removeAttr("disabled");
        $(".aftr-edt").show();
    });
    $(".chg-psw").change(function() {
        if ($(this).is(":checked")) {
            $(".Change-pswd").show();
        } else {
            $(".Change-pswd").hide();
        }
    });
    function updateNotifiSetting(type, value) {
        $.ajax({
            method: "get",
            url: "/updatenotification_setting",
            data: { type: type, value: value },
            success: function(result) {
                return;
            }
        });
    }
    function updateShippingPrice(shippingPrice, id) {
        $.ajax({
            method: "get",
            url: "/getShippingMethodInfo",
            data: { id: id },
            success: function(result) {
                if (result) {
                    $("#shipping_method_name").html(result.title_en);
                    $("#shipping_method_desc").html(result.description_en);
                }

                return;
            }
        });
        var total = $("#total").val();
        $(".shippingcharges").html(parseFloat(shippingPrice));
        $("#shippingcharges").val(parseFloat(shippingPrice));
        $(".totalcharges").html(
            (parseFloat(shippingPrice) + parseFloat(total)).toFixed(2)
        );
    }
    function updateShippingPriceDhL(shippingPrice , title , desc) {
        var total = $("#total").val();

        $(".shippingcharges").html(parseFloat(shippingPrice));
        $("#shippingcharges").val(parseFloat(shippingPrice));
        $("#shipping_method_name").html(title);
        $("#shipping_method_desc").html(desc);
        $(".totalcharges").html(
            (parseFloat(shippingPrice) + parseFloat(total)).toFixed(2)
        );
    }
    function showBillingAddress(val) {
        $.ajax({
            method: "get",
            url: "/getAddressDetails",
            data: { id: val },
            success: function(result) {
                if (result) {

                    if(result.governorate_id == 1 )
                    {
                        $('#codDiv').show();
                    }
                    else
                    {
                        $('#codDiv').hide();
                    }
                    $(".addres_label").html(
                        result.user_label +
                            " " +
                            result.first_name +
                            " " +
                            result.last_name
                    );
                    $(".addres_address").html(result.first_address);
                    $(".addres_city").html(result.city);
                    $(".addres_provience").html(result.provience.title_en);
                    $(".addres_postcode").html(result.post_code);
                    $(".addres_phone").html(result.phone_no);
                    $(".addres_mobile").html(result.mobile_no);

                    getShippingMethods(result.id);
                }

                return;
            }
        });
    }

    $(".addShippingAddress").click(function() {
        $(".checkout_new_address_errors").html("");
        $("#addShippingAddress").attr("disabled", true);
        $("#addBillingAddress").attr("disabled", true);
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });

        var $data = $(this)
            .parents("form:first")
            .serializeArray();


        $.ajax({
            method: "post",
            url: "/addAddress",
            data: $.param($data),
            success: function(result) {

                $('.addressid'+$('#shippingAddressId').val()).remove();
                if (result.type == "2") {
                    $("#allShippingAddress").append(

                        checkoutAppendAddress(result)
                    );
                    // showBillingAddress(result.id);
                    // $("#allBillingAddress").append(
                    //     checkoutAppendAddress(result)
                    // );
                    $('#addShippingAddressForm').parent().css('display' , 'none');
                    $('#addShippingAddressForm').trigger("reset");
                    $('#hide-billing').show();
                } else {
                    $("#allBillingAddress").append(
                        checkoutAppendAddress(result)
                    );
                    $('#addBillingAddressForm').parent().css('display' , 'none');
                    $('#addBillingAddressForm').trigger("reset");

                }
                $("#addShippingAddress").attr("disabled", false);
                $("#addBillingAddress").attr("disabled", false);
                return;
            },
            error(errors) {
                $.each(errors.responseJSON.errors, function(key, value) {
                    $(".checkout_new_address_errors").append(
                        '<strong class"error"">' + value + "</strong><br />"
                    );
                });
                $("#addShippingAddress").attr("disabled", false);
                $("#addBillingAddress").attr("disabled", false);
            }
        });
    });
    $("#next-btn").click(function() {
        $(".nav-tabs a:last").tab("show");
    });
    $("#apply_discount").click(function() {
        data = {
            discount_code: $("#discount_code").val(),
            total: $("#total").val(),
            _token: $("input[name=_token]").val(),
            shippingcharges: $("#shippingcharges").val()
        };
        $.ajax({
            method: "post",
            url: "/apply_discount",
            data: data,
            success: function(result) {
                $(".discount_code_success_message").html('');
                $(".discount_code_error_message").html('');                    

                $(".totalcharges").html(result.total);
                if(result.success){
                    $(".discount_code_success_message").html(result.message);
                }else{
                    $(".discount_code_error_message").html(result.message);                    
                }
            }
        });
    });
    $("#placeOrderBtn").click(function() {
        $(".checkout_submit_form_errors").html('');
        data = {
            shipping_method: $('[name="shipping_method"]:checked').val(),
            address_id: $('[name="address_id"]:checked').val(),
            billing_address_id: $('[name="billing"]:checked').val(),
            payment_method: $('[name="payment_method"]:checked').val(),
            preferred_date: $('[name="preferred-date"]').val(),
            _token: $("input[name=_token]").val(),
            total: $("#total").val(),
            discount_code: $("#discount_code").val()
        };
        $.ajax({
            method: "post",
            url: "/place_order",
            data: data,
            success: function(result) {
                if (result.status == "true") {

                    if(result.knetpayment == 1)
                    {
                        window.location.href =   result.data.knetUrl + result.data.params;
                    }
                    else {
                        window.location.href = "/order/" + result.id;
                    }
                }
            },error(error){
                $.each(error.responseJSON.errors, function(key, value) {
                    $(".checkout_submit_form_errors").append(
                        '<li>' + value + "</li>"
                    );
                });
                $(".checkout_submit_form_errors").addClass('alert alert-danger');
                scrollTop('checkout_submit_form_errors');
            }
        });

       
    });
    $("#placeCardOrderBtn").click(function() {
        $(".checkout_submit_form_errors").html('');
        data = {

            payment_method: $('[name="payment_method"]:checked').val(),

            _token: $("input[name=_token]").val(),
            total: $("#total").val(),
            discount_code: $("#discount_code").val()
        };
        $.ajax({
            method: "post",
            url: "/place_card_order",
            data: data,
            success: function(result) {
                if (result.status == "true") {

                    if(result.knetpayment == 1)
                    {
                        window.location.href =   result.data.knetUrl + result.data.params;
                    }
                    else {
                        window.location.href = "/order/" + result.id;
                    }
                }
            },error(error){
                $.each(error.responseJSON.errors, function(key, value) {
                    $(".checkout_submit_form_errors").append(
                        '<li>' + value + "</li>"
                    );
                });
                $(".checkout_submit_form_errors").addClass('alert alert-danger');
                scrollTop('checkout_submit_form_errors');
            }
        });


    });

    $("#search_input").keyup(function() {
        value = $(this).val();
        if ($("#possible_tags option").length > 0) {
            return;
        }
        $.ajax({
            method: "get",
            url: "/products/auto_complete_tags",
            success: function(result) {
                $("#possible_tags").empty();

                $.each(result, function(i, item) {
                    $("#possible_tags").append(
                        $("<option>")
                            .attr("value", item)
                            .text(item)
                    );
                });
            }
        });
    });

    $(".country").change(function() {
        $.ajax({
            method: "get",
            url: "/get_provience/" + this.value,

            success: function(result) {
                $("select.province").html("");
                $("select.province").html(
                    "<option value='0'>please select</option>"
                );
                result.forEach(function(element) {
                    $("select.province").append(
                        "<option value=" +
                            element.id +
                            ">" +
                            element.title_en +
                            "</option>"
                    );
                });
            }
        });
    });
    $(".province").change(function() {
        $.ajax({
            method: "get",
            url: "/get_cities/" + this.value,

            success: function(result) {
                $("select.city").html("");
                $("select.city").html(
                    "<option value='0'>please select</option>"
                );
                result.forEach(function(element) {
                    $("select.city").append("<option >"+element.title_en + "</option>");
                });
            }
        });
    });
    function checkoutAppendAddress(result) {
        return (
            "<hr>" +
            "<br>" +
            '<div class="row addressid'+result.id+'">' +
            '<div class="col-xs-1 Checkout-address-checkbox">' +
            '<input type="radio" value="' +
            result.id +
            '" name="address_id" id="address_id" checked onclick="showBillingAddress(' +
            result.id +
            ')" class="form-radio address-radio-check">' +
            "</div>" +
            '<div class="col-xs-11 Checkout-address-text">' +
            '<p class=""><span>' +
            result.address_type +
            "</span></p>" +
            '<p class="">Name : ' +
            result.user_label +
            " " +
            result.first_name +
            " " +
            result.last_name +
            "</p>" +
            '<p class="">Addres : ' +
            result.first_address +
            "</p>" +
            '<p class="">City : ' +
            result.city +
            "</p>" +
            '<p class="">Territory : ' +
            result.provience.title_en +
            "</p>" +
            '<p class="">Postal Code : ' +
            result.post_code +
            "</p>" +
            '<p class="">Phone Number : ' +
            result.phone_no +
            "</p>" +
            '<p class="">Mobile Number : ' +
            result.mobile_no +
            "</p>" +
            "</div>" +
            "</div>" +
            "<br>"
        );
    
    
    }

    function getShippingMethods(address_id){
        $.ajax({
            method: "get",
            url: "/checkout/get_shipping_methods?address_id=" + address_id,
            success: function(result) {
                console.log(result.html);
               $('#shipping_methods').html('');
               $('#shipping_methods').html(result.html);
            }
        });
    }

    function scrollTop(div_id){
        $('html, body').animate({
            scrollTop: $("#" + div_id).offset().top
        }, 250);
    }

    $.ajaxSetup({
        beforeSend:function(){

            $(".loading-holder").show();
        },
        success:function(){

            $(".loading-holder").hide();
        },


    });
function editAddress() {
    $addressID = $("input[name='address_id']:checked").val();
    
    $.ajax({
        method: "get",
        url: "/getAddressDetails",
        data: { id: $addressID },
        success: function(result) {
            $('#hrefItemDetails').click();
            $('#addNewShippingAddress').click();
            if (result) {


                $("input[name='shippingAddressId']").val($addressID);
                $("input[name='address_type']").val(result.address_type);
                $("input[name='user_label']").val(result.user_label);
                $("input[name='first_name']").val(result.first_name);
                $("input[name='last_name']").val(result.last_name);
                $("#governorate_id").prop('selectedIndex', result.governorate_id);
                $("#city").val(  result.city);
                $("input[name='first_address']").val(result.first_address);

                $("input[name='second_address']").val(result.second_address);
                $("input[name='post_code']").val(result.post_code);

                $("#province").prop('selectedIndex', result.governorate_id);
                $("input[name='phone_no']").val(result.phone_no);
                $("input[name='mobile_no']").val(result.mobile_no);


            }

            return;
        }
    });
}
</script>
</script>

<script>
    <!-- validation messages --> 
  jQuery.extend(jQuery.validator.messages, {
    required: "{{__('validation.required_js')}}",
    email: "{{__('validation.email_js')}}",
  });
  <!-- end valitation messages -->



</script>
