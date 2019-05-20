
//Review Payment Page check box hide show div

$(function () {
        $("#radio-three").click(function () {
            if ($(this).is(":checked")) {
                $("#hide-billing").hide();
            } else {
                $("#hide-billing").show();
            }
        });
    });



//Show Hide Toogle CHeckout Page

$(document).ready(function() {

	$('.show-form').click(function() {
    var today = new Date().toISOString().split('T')[0];
    // $(".next-date")[0].setAttribute('min', today);
	  $('.hidden-form').slideToggle("slow");
	  // Alternative animation for example
	  // slideToggle("fast");
	});
	$('.show-form2').click(function() {
	  $('.hidden-form2').slideToggle("slow");
	  // Alternative animation for example
	  // slideToggle("fast");
	});
});


// price range

$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 55,
      max: 1500,
      values: [ 0, 1500 ],
      slide: function( event, ui ) {
		$( "#amountfrm" ).val( "KD " + ui.values[ 0 ]);
		$( "#amountto" ).val( "KD " + ui.values[ 1 ]);
		
      }
    });
	$( "#amountfrm" ).val( "KD " + $( "#slider-range" ).slider( "values", 0 ));
	$( "#amountto" ).val( "KD " + $( "#slider-range" ).slider( "values", 0 ));
  } );

// price range




// Date get push value
$("#countries_msdd").click(function(){
	$(this)("#countries_child").show();
	});

	$('.next-date').change(function() {
            
		$('.absolute-date').val($(this).val());
	});
// Date get push value


// upload file get push value
	$('.upld').on('change',function(){
		// output raw value of file input
		$('.abs-upld').html($(this).val()); 
	  
	   // or, manipulate it further with regex etc.
	   var filename = $(this).val();
	   // .. do your magic
	  
	   $('.abs-upld').val(filename);
	  });
// upload file get push value



$(document).ready(function (e) {
	//no use
	try {
		var pages = $("#pages").msDropdown({
			on: {
				change: function (data, ui) {
					var val = data.value;
					if (val != "")
						window.location = val;
				}
			}
		}).data("dd");

		var pagename = document.location.pathname.toString();
		pagename = pagename.split("/");
		pages.setIndexByValue(pagename[pagename.length - 1]);
		$("#ver").html(msBeautify.version.msDropdown);
	} catch (e) {
		//console.log(e);	
	}

	$("#ver").html(msBeautify.version.msDropdown);

	//convert
	$("#countries").msDropdown({ roundedBorder: false });
	createByJson();
	$("#tech").data("dd");
	
});

function showValue(h) {
	console.log(h.name, h.value);
}

$("#tech").change(function () {
	console.log("by jquery: ", this.value);
})
//
$(".inpt").keyup(function () {
	if (this.value.length == this.maxLength) {
		$(this).parent().next(".col-md-2.col-sm-2.col-xs-2").find('.inpt').focus();
	}
});

// $(".dropdown-toggle").mouseover(function () {
// 	if (!$(this).parent().hasClass("open")) {
// 		$(this).trigger("click");
// 		$("ul.dropdown-menu.mega-dropdown-menu.row").show(600)
// 	}
// });



$(window).load(function(){
	if (this.innerWidth > 960) {
		// $(".dropdown-toggle").removeAttr("data-toggle");
		// $(".dropdown-toggle").attr("data-hover","dropdown");
		// alert("asdasddas");
		$(".dropdown-toggle").parent("li").mouseover(function(){
		$("ul.dropdown-menu.mega-dropdown-menu.row").show(200).slideDown(600);
		});
		$(".dropdown-toggle").parent("li").mouseleave(function(){
		$("ul.dropdown-menu.mega-dropdown-menu.row").hide(200).slideUp(600);
		});
	}
	});


$('#search_button').on('click', function (fn) {
	fn.preventDefault();
	$('.search_box_cover').addClass('active');
});
$('#closeButton').on('click', function (fn) {
	fn.preventDefault();
	$('.search_box_cover').removeClass('active');
});

$('.remove').on('click', function (e) {
	e.preventDefault();
	e.stopPropagation();
	$(this).closest('.border_dashed').slideUp('300', deleteData());
});
$('.remove_list').on('click', function (e) {
	e.preventDefault();
	e.stopPropagation();
	$(this).closest('.whish_gray_bx').slideUp('300', deleteData());
});
$('#cartEnable').on('click', function (e) {
    
	$(this).addClass('car_act');
	e.preventDefault();
	e.stopPropagation();
	$('.cart_box').show(600);

});
$(document).on('click', function (e) {
	$('#cartEnable').removeClass('.car_act');
	if (e.target.id === 'cart_bx' || $(e.target).parents('#cart_bx').length > 0) {
		e.stopPropagation();
	} else {
		$('.cart_box').hide(600);
	}
});
$(".bannerSlider").slick({
	dots: false,
	autoplay: true,
	infinite: true,
	slidesToShow: 1,
	slideswToScroll: 1,
	arrows: true,
	fade: true,
	cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
	speed: 900,
	touchThreshold: 100
});
$(".slid-new-arriwal").slick({
	dots: false,
	autoplay: true,
	infinite: true,
	slidesToShow: 4,
	slideswToScroll: 1,
	arrows: true,
	responsive: [
		{
		  breakpoint: 768,
		  settings: {
			slidesToShow: 1
		  }
		}
	  ]
});


$(".brands-slid").slick({
	dots: false,
	autoplay: true,
	infinite: true,
	slidesToShow: 6,
	slidesToScroll:1,
	arrows: false,
	responsive: [
		{
		  breakpoint: 992,
		  settings: {
			slidesToShow: 4
		  }
		},
		{
			breakpoint: 768,
			settings: {
			  slidesToShow: 3
			}
		  },
		  {
			breakpoint:500,
			settings: {
			  slidesToShow: 3
			}
		  },
		  {
			breakpoint: 430,
			settings: {
			  slidesToShow: 2
			}
		  },
		  {
			breakpoint:380,
			settings: {
			  slidesToShow: 1
			}
		  }
	  ]
});


$(function (a) {
	$("#faq").accordion({
		collapsible: true
	});
});

$(".delete-4-cart").click(function () {
	$(this).parents(".border_dashed.full-width").hide(1000);
});



	// inner details counter
	var quantitiy = 0;
	$('.quantity-right-plus').click(function (e) {
		e.preventDefault();
		var quantity = parseInt($(this).parents('.counter').find(".input-number").val());
		if (quantity < 100) {
		$($(this).parents('.counter').find(".input-number")).val(quantity + 1);
		}
	});

	$('.quantity-left-minus').click(function (e) {
		e.preventDefault();
		var quantity = parseInt($(this).parents('.counter').find(".input-number").val());

		if (quantity > 0) {
			$($(this).parents('.counter').find(".input-number")).val(quantity - 1);
		}
	});



// when product size checkbox checked change label color to red
$('.product-size-checkbox-container input[type="checkbox"]').click(function () {
	if ($(this).is(':checked')) {
		$(this).closest('li').find('label').css("color", "#be1522");
	}
	else {
		$(this).closest('li').find('label').css("color", "black");
	}
})
$(".chat-clk").click(function(){
	$(".chat-box").toggle(400);
});
$(".clox").click(function(){
	$(".chat-box").hide(400);
});

// cehckout review tab click show panels
$('.sec-checkout .review-tab').click(function(){
    
	$('.sec-checkout .discount-li').removeClass('hidden');
	$('.sec-checkout .panel-ship-to').removeClass('hidden');
	$('.sec-checkout .panel-ship-method').removeClass('hidden');
	$('.sec-checkout .btn-place-oreder').removeClass('hidden');
	$('.sec-checkout .i-agree').removeClass('hidden');
	$('.sec-checkout .next-btn').addClass('hidden');
});

// cehckout review tab click show panels
$('.next-btn').click(function(){
    
	$('.sec-checkout .discount-li').removeClass('hidden');
	$('.sec-checkout .panel-ship-to').removeClass('hidden');
	$('.sec-checkout .panel-ship-method').removeClass('hidden');
	$('.sec-checkout .btn-place-oreder').removeClass('hidden');
	$('.sec-checkout .i-agree').removeClass('hidden');
	$('.sec-checkout .next-btn').addClass('hidden');
});

// shipping tab click hide panels
$('.sec-checkout .shipping-tab').click(function(){
	$('.sec-checkout .discount-li').addClass('hidden');
	$('.sec-checkout .panel-ship-to').addClass('hidden');
	$('.sec-checkout .panel-ship-method').addClass('hidden');
	$('.sec-checkout .btn-place-oreder').addClass('hidden');
	$('.sec-checkout .i-agree').addClass('hidden');
	$('.sec-checkout .next-btn').removeClass('hidden');
});

// Item slider inner details page
	$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			fade: true,
			asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.slider-for',
			dots: false,
			arrows: false,
			centerMode: false,
			focusOnSelect: true
	});


$(".remove-disabled").click(function (q) {
	q.stopPropagation();
	$(".inpt").removeAttr("disabled");
	$(".aftr-edt").show();
});
$(".chg-psw").change(function () {
	if ($(this).is(':checked')) {
		$(".Change-pswd").show();
	}
	else {
		$(".Change-pswd").hide();
	};


});
		

