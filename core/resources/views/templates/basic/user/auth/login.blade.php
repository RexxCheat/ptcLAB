@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $loginCaption = getContent('login.content',true);
@endphp
<section class="pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="login-area">
            <h2 class="title mb-3">{{ __($loginCaption->data_values->heading) }}</h2>
            <form class="action-form loginForm verify-gcaptcha" action="{{ route('user.login') }}" method="post">
              @csrf
              <div class="form-group">
                <label>@lang('Username or Email')</label>
                <div class="input-group">
                  <div class="input-group-text"><i class="las la-user"></i></div>
                  <input type="username" name="username" class="form-control" placeholder="@lang('Username or Email')" required>
                </div>
              </div><!-- form-group end -->
              <div class="form-group mb-3">
                <label>@lang('Password')</label>
                <div class="input-group">
                  <div class="input-group-text"><i class="las la-key"></i></div>
                  <input type="password" name="password" class="form-control" placeholder="@lang('Password')" required>
                </div>
              </div><!-- form-group end -->
              <x-captcha></x-captcha>
              <div class="form-group form-check">
                <input class="form-check-input w-auto p-2" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    @lang('Remember Me')
               </label>
            </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn--base w-100">@lang('Login Now')</button>
                <p class="mt-20">@lang('Forget your password?') <a href="{{ route('user.password.request') }}">@lang('Reset password')</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
