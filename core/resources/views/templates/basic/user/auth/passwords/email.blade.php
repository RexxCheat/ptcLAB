@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-7">
                <div class="password-area">
                    <h3 class="title mb-2">{{ __($pageTitle) }}</h3>
                    <div class="mb-4">
                        <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                    </div>
                    <form method="POST" action="{{ route('user.password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Email or Username')</label>
                            <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            <p class="mt-20"><a href="{{ route('user.login') }}">@lang('Back to login')</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
