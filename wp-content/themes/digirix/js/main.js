// -------------------------------------------------- Main Slider ------------------------------------------------------------------------//
$('.main-slider').slick({
    dots: true,
	
	autoplay: false,
    autoplaySpeed: 2000,
    pauseOnDotsHover: true,
    customPaging: function(slider, i) {
      // this example would render "tabs" with titles
      return '<span class="cus_dot2"></span>';
    }
  });

// --------------------------------------------------Thumb Slider------------------------------------------------------------------------//
 $('.item-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  fade: true,
  asNavFor: '.thumb-slider'
});
$('.thumb-slider').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.item-slider',
  arrows: false,
  centerMode: true,
  focusOnSelect: true,
     responsive: [{
      breakpoint: 767,
      settings: {
        slidesToShow: 2,
      }
         
     } ]

});
// --------------------------------------------------Clients Carousel------------------------------------------------------------------------//
$('.client').slick({
  slidesToShow: 5,
  infinite: true,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 4510,
   responsive: [{
      breakpoint: 639,
      settings: {
        slidesToShow: 2,
      }}]
});
// --------------------------------------------------Services Carousel------------------------------------------------------------------------//
$('.client_slides').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3000,
    responsive: [
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 3,
         autoplay: true,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
  
});
// --------------------------------------------------Testimonials Carousel------------------------------------------------------------------------//
/*********testimonial************/
$('.testimonial').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  adaptiveHeight: true,
  arrows: false,
  dots:false,
    customPaging: function(slider, i) {
      // this example would render "tabs" with titles
      return '<span class="cus_dot"></span>';
    },
    responsive: [{
      breakpoint: 767,
      settings: {
        slidesToShow: 1,
      }}]
});


$(document).ready(function() {
	$('#menu-main-menu-1').onePageNav();
	
	if($('html').attr('lang') == 'ar'){
	$('body').addClass('ar');	
	}else{
		$('body').addClass('en');
	}
	
});



// --------------------------------------------------Tabs------------------------------------------------------------------------//
$(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});
// --------------------------------------------------Tabs Left------------------------------------------------------------------------//
$(document).ready(function() {
    $(".tabs-left a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tabsleft-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});
// --------------------------------------------------Accordion-----------------------------------------------------------------------//
$(document).ready(function(){
  $('.set > a').on("click", function(){
    if($(this).hasClass('active')){
      $(this).removeClass("active");
      $(this).siblings('.content').slideUp(200);
      $(".set > a i").removeClass("fa-minus").addClass("fa-plus");
    }else{
      $(".set > a i").removeClass("fa-minus").addClass("fa-plus");
    $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
    $(".set > a").removeClass("active");
    $(this).addClass("active");
    $('.content').slideUp(200);
    $(this).siblings('.content').slideDown(200);
    } 
  });
});
// --------------------------------------------------Custom Scroll bar------------------------------------------------------------------------//
(function($){
	$(window).on("load",function(){
		$(".customscroll").mCustomScrollbar({
			theme:"minimal"
		});
	});
})(jQuery);

/************Isotope*************/
$(window).on("load", function () {
    var $grid = $('.grid').isotope({
        layoutMode: 'packery',
        itemSelector: '.grid-item',
        packery: {
            gutter: 0
        }
    });
    // filter items on button click
    $('.filter-button-group').on('click', 'button', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
            filter: filterValue
        });
    });
});

// --------------------------------------------------Responsive Simple Navigation----------------------------------------------//
(function ($) {
        $.fn.menumaker = function (options) {
                var cssmenu = $(this), settings = $.extend({
title: "Menu",
format: "dropdown",
sticky: false
}, options);
return this.each(function() {
cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
$(this).find("#menu-button").on('click', function(){
$(this).toggleClass('menu-opened');
var mainmenu = $(this).next('ul');
if (mainmenu.hasClass('open')) { 
mainmenu.hide().removeClass('open');
}else {
mainmenu.show().addClass('open');
if (settings.format === "dropdown") {
mainmenu.find('ul').show();}}});
cssmenu.find('li ul').parent().addClass('has-sub');
multiTg = function() {
cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
cssmenu.find('.submenu-button').on('click', function() {
$(this).toggleClass('submenu-opened');
if ($(this).siblings('ul').hasClass('open')) {
$(this).siblings('ul').removeClass('open').hide();}
else {$(this).siblings('ul').addClass('open').show();}});};
if (settings.format === 'multitoggle') multiTg();
else cssmenu.addClass('dropdown');
if (settings.sticky === true) cssmenu.css('position', 'fixed');
resizeFix = function() {
if ($( window ).width() > 768) {
cssmenu.find('ul').show();}
if ($(window).width() <= 768) {
cssmenu.find('ul').hide().removeClass('open');}};
resizeFix();
return $(window).on('resize', resizeFix);});};
})(jQuery);
(function($){
$(document).ready(function(){
$(".menu-header").menumaker({
title: "Menu",
format: "multitoggle"
});});})(jQuery);

// --------------------------------------------------Humberg Push Navigation------------------------------------------------------------------------//
(function($){
jQuery(document).ready(function(){
jQuery('.menu-main-menu-container').navAccordion({
	expandButtonText: '›',  //Text inside of buttons can be HTML
	collapseButtonText: '‹'}, 
function(){	console.log('Callback')});
});
  $('a#hamburg').on('click',function(e){
    $('html').toggleClass('open-menu');
    return false;
  });
  $('div#hamburg').on('click',function(){
    $('html').removeClass('open-menu');
  })
  $(document).ready(function(){
	$('.nav-cross').click(function(){
		$(this).toggleClass('open');
	});
});
})(jQuery)
/*------------------------------------------- ------- Header Fix---------------------------------------------------------------*/
$(function(){
var shrinkHeader = 200;
$(window).scroll(function() {
var scroll = getCurrentScroll();
  if ( scroll >= shrinkHeader ) {
	   $('.headerbottom').addClass('fixed');}
	else {
		$('.headerbottom').removeClass('fixed');}});
function getCurrentScroll() {
return window.pageYOffset;
}});
/*    ----------------------------------------------- Windows Size -------------------------------------------------------- */
var WindowsSize=function(){
var h=$(window).height(),w=$(window).width();
$("#winSize").html("<p>Width: "+w+"<br>Height: "+h+"</p>");};
$(document).ready(function(){WindowsSize();}); 
$(window).resize(function(){WindowsSize();}); 
/*----------------------------------------------------Back to top---------------------------------------------------------------*/
$(document).ready(function(){$("#back-top").hide();$(function(){$(window).scroll(function(){if($(this).scrollTop()>100){$("#back-top").fadeIn()}else{$("#back-top").fadeOut()}});$("#back-top a").click(function(){$("body,html").animate({scrollTop:0},800);return false})})})


$(document).ready(function() {
	$('a[rel="relativeanchor"]').click(function(){
	    $('html, body').animate({
	        scrollTop: $( $.attr(this, 'href') ).offset().top
	    }, 500);
	    return false;
	}); 

});




var wrap = $("#scrol");

wrap.on("scroll", function(e) {
    
  if (this.scrollTop > 147) {
    wrap.addClass("fix-search");
  } else {
    wrap.removeClass("fix-search");
  }
  
});

//$('#wpas_form_registration').attr('onsubmit', 'myform()');
/***Registeration Validate****/	
	  $('#wpas_password').on("focusout", function(){
	    var passwrd =   $('#wpas_password').val();
	      if(passwrd.length == 0){
	          console.log(passwrd + ' 1');
	          $('#error_pass').remove();
	          $( "#wpas_password_wrapper" ).append($( "<div id='error_pass'>Please Enter Password</div>" ));
	          $(".wpas-btn-default").attr("disabled", "disabled");
	          return false;
	          
	          }
	          else if(passwrd.length < 6){
	           $('#error_pass').remove();
	           $( "#wpas_password_wrapper" ).append($( "<div id='error_pass'>Please enter atleast 6 letters in password</div>" ));
	           $(".wpas-btn-default").attr("disabled", "disabled");
	           console.log('Second Condition');
	          return false;
	              }
	          else{
	             $('#error_pass').remove();
	             $('.wpas-btn-default').removeAttr("disabled");
	              console.log('Succuss');
	              }

	   });
