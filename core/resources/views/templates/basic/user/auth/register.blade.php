@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $policyPages = getContent('policy_pages.element',false,null,true);
    $registerCaption = getContent('register.content',true);
@endphp
    <section class="pt-120 pb-120">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="login-area">
                <h2 class="title mb-3">{{ __($registerCaption->data_values->heading) }}</h2>
                <form class="action-form verify-gcaptcha loginForm" action="{{ route('user.register') }}" method="post">
                  @csrf
                  @if(session()->get('reference') != null)
                    <div class="form-group">
                        <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                        <input type="text" name="referBy" id="referenceBy" class="form-control" value="{{session()->get('reference')}}" readonly>
                    </div>
                   @endif

                   <div class="form-group">
                    <label>@lang('Username')</label>
                    <input type="text" name="username" placeholder="@lang('Username')" class="form-control checkUser" value="{{ old('username') }}" required>
                    <small class="text-danger usernameExist"></small>
                  </div><!-- form-group end -->


                  <div class="form-group">
                    <label>@lang('Email')</label>
                    <input type="email" name="email" placeholder="@lang('Email')" class="form-control checkUser" value="{{ old('email') }}" required>
                  </div><!-- form-group end -->

                    <div class="form-group">
                        <label class="form-label">@lang('Country')</label>
                        <select name="country" class="form-select form--select" required>
                            @foreach($countries as $key => $country)
                                <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Mobile')</label>
                        <div class="input-group ">
                            <span class="input-group-text mobile-code">

                            </span>
                            <input type="hidden" name="mobile_code">
                            <input type="hidden" name="country_code">
                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                        </div>
                        <small class="text-danger mobileExist"></small>
                    </div>

                  <div class="form-group hover-input-popup">
                    <label>@lang('Password')</label>
                    <input type="password" name="password" placeholder="@lang('Password')" class="form-control" required>
                     @if($general->secure_password)
                        <div class="input-popup">
                          <p class="error lower">@lang('1 small letter minimum')</p>
                          <p class="error capital">@lang('1 capital letter minimum')</p>
                          <p class="error number">@lang('1 number minimum')</p>
                          <p class="error special">@lang('1 special character minimum')</p>
                          <p class="error minimum">@lang('6 character password')</p>
                        </div>
                    @endif
                  </div><!-- form-group end -->
                  <div class="form-group mb-3">
                    <label>@lang('Re-type Password')</label>
                    <input type="password" name="password_confirmation" placeholder="@lang('Re-type Password')" class="form-control" required>
                  </div><!-- form-group end -->
                  <x-captcha></x-captcha>
                  @if($general->agree)
                  <div class="form-group">
                    <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                    <label for="agree">@lang('I agree with') @foreach($policyPages as $policy) <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a> @if(!$loop->last), @endif @endforeach</label>
                  </div><!-- form-group end -->
                  @endif
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn--base w-100">@lang('Register Now')</button>
                    <p class="mt-20">@lang('Already have an account?') <a href="{{ route('user.login') }}">@lang('Login Now')</a></p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>


<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="las la-times"></i>
        </span>
      </div>
      <div class="modal-body">
        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
        <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('style')
<style>
    .country-code .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
      "use strict";
        (function ($) {
            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });

                $('[name=password]').focus(function () {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function () {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });


            @endif

            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){
                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                  }else{
                    $(`.${response.type}Exist`).text('');
                  }
                });
            });
        })(jQuery);

    </script>
@endpush
