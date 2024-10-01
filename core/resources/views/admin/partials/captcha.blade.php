@php
	$customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha()
@endphp
@if($googleCaptcha)
    <div class="mb-3">
        @php echo $googleCaptcha @endphp
    </div>
@endif
@if($customCaptcha)
    <div class="mb-2">
        @php echo $customCaptcha @endphp
    </div>
    <div class="form-group">
        <label>@lang('Captcha')</label>
        <input type="text" name="captcha" placeholder="@lang('Enter Captcha Code')" class="form-control b-radius--capsule" required>
        <i class="las la-fingerprint input-icon"></i>
    </div>
@endif
@push('script')
    <script>
    (function($){
        "use strict"
        $('.verify-gcaptcha').on('submit',function(){
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        });
    })(jQuery);
    </script>
@endpush
