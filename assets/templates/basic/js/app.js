'use strict';

// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 50){  
        fixed_top.addClass("animated fadeInDown menu-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown menu-fixed");
    }
});

$('.navbar-toggler').on('click', function (){
	$('.header').toggleClass('active');
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

let img=$('.bg_img');
img.css('background-image', function () {
	let bg = ('url(' + $(this).data('background') + ')');
	return bg;
});

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

	$('.nic-select').niceSelect();

	new WOW().init();
	
	  // lightcase plugin init
		$('a[data-rel^=lightcase]').lightcase();

/* Get the documentElement (<html>) to display the page in fullscreen */
let elem = document.documentElement;

// mainSlider
function mainSlider() {
	var BasicSlider = $('.hero__slider');
	BasicSlider.on('init', function (e, slick) {
		var $firstAnimatingElements = $('.single__slide:first-child').find('[data-animation]');
		doAnimations($firstAnimatingElements);
	});
	BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
		var $animatingElements = $('.single__slide[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
		doAnimations($animatingElements);
	});
	BasicSlider.slick({
		autoplay: false,
		autoplaySpeed: 10000,
		dots: false,
		fade: true,
		arrows: true,
		nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
    prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
		responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						infinite: true,
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false
					}
				}
			]
	});

	function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
		});
	}
}
mainSlider();

$('.category-slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  speed: 700,
  dots: false,
  arrows: true,
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
	prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
	responsive: [
		{
      breakpoint: 1200,
      settings: {
				dots: true,
				arrows: false
      }
    },
    {
      breakpoint: 576,
      settings: {
				slidesToShow: 2,
				dots: true,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
				slidesToScroll: 1,
				dots: true,
      }
    }
  ]
});

$('.testimonial-slider').slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  speed: 700,
  dots: true,
	arrows: false,
	responsive: [
		{
      breakpoint: 768,
      settings: {
				slidesToShow: 1
      }
    }
  ]
});

// Show or hide the sticky footer button
$(window).on("scroll", function() {
	if ($(this).scrollTop() > 200) {
			$(".scroll-to-top").fadeIn(200);
	} else {
			$(".scroll-to-top").fadeOut(200);
	}
});

// Animate the scroll to top
$(".scroll-to-top").on("click", function(event) {
	event.preventDefault();
	$("html, body").animate({scrollTop: 0}, 300);
});


//preloader js code
$(".preloader").delay(300).animate({
	"opacity" : "0"
	}, 300, function() {
	$(".preloader").css("display","none");
});