@extends($activeTemplate.'layouts.master')
@section('content')
<div class="cmn-section">
    <div class="container">
        <div class="row justify-content-center gy-4">

            @if(!auth()->user()->ts)
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">@lang('Add Your Account')</h5>
                    </div>

                    <div class="card-body">
                        <h6 class="mb-3">
                            @lang('Use the QR code or setup key on your Google Authenticator app to add your account. ')
                        </h6>

                        <div class="form-group mx-auto text-center">
                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Setup Key')</label>
                            <div class="input-group">
                                <input type="text" name="key" value="{{$secret}}" class="form-control form--control referralURL" readonly>
                                <button type="button" class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                            </div>
                        </div>

                        <label><i class="fa fa-info-circle"></i> @lang('Help')</label>
                        <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a></p>
                    </div>
                </div>
            </div>

            @endif

            <div class="col-md-6">

                @if(auth()->user()->ts)
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="title">@lang('Disable 2FA Security')</h5>
                        </div>
                        <form action="{{route('user.twofactor.disable')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="key" value="{{$secret}}">
                                <div class="form-group">
                                    <label class="form-label">@lang('Google Authenticatior OTP')</label>
                                    <input type="text" class="form-control form--control" name="code" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="title">@lang('Enable 2FA Security')</h5>
                        </div>
                        <form action="{{ route('user.twofactor.enable') }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="key" value="{{$secret}}">
                                <div class="form-group">
                                    <label class="form-label">@lang('Google Authenticatior OTP')</label>
                                    <input type="text" class="form-control form--control" name="code" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }};
    }
</style>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $('#copyBoard').click(function(){
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
