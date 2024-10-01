<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}"/>

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lightcase.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/animate.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/nice-select.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/vendor/slick.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/main.css') }}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color1={{ $general->base_color }}&color2={{ $general->secondary_color }}">
</head>
<body>

@stack('fbComment')


<div class="preloader">
    <div class="dl">
      <div class="dl__container">
        <div class="dl__corner--top"></div>
        <div class="dl__corner--bottom"></div>
      </div>
      <div class="dl__square"></div>
    </div>
</div>

<!-- scroll-to-top start -->
<div class="scroll-to-top">
    <span class="scroll-icon">
        <i class="fa fa-rocket" aria-hidden="true"></i>
    </span>
</div>
<!-- scroll-to-top end -->

@yield('panel')

@include($activeTemplate.'partials.footer')


@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card text-center hide">
      <div class="cookies-card__icon bg--base">
        <i class="las la-cookie-bite"></i>
      </div>
      <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
      <div class="cookies-card__btn mt-4">
        <a href="javascript:void(0)" class="btn cmn-btn w-100 policy">@lang('Allow')</a>
      </div>
    </div>
  <!-- cookies dark version end -->
  @endif


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

  <!-- lightcase plugin -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/lightcase.js') }}"></script>
  <!-- custom select js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery.nice-select.min.js') }}"></script>
  <!-- slick slider js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/slick.min.js') }}"></script>
  <!-- scroll animation -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/wow.min.js') }}"></script>
  <!-- dashboard custom js -->
  <script src="{{ asset($activeTemplateTrue.'/js/app.js')}}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            var type = element.attr('type');
            if(type != 'checkbox'){
                element.closest('.form-group').find('label').attr('for',element.attr('name'));
                element.attr('id',element.attr('name'))
            }
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });

        $('.showFilterBtn').on('click',function(){
            $('.responsive-filter-card').slideToggle();
        });

    })(jQuery);
</script>

</body>
</html>
