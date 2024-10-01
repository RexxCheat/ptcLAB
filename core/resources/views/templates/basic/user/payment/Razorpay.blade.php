@extends($activeTemplate.'layouts.master')
@section('content')
<div class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">@lang('Razorpay')</h5>
                    </div>
                    <div class="card-body p-5">
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                            </li>
                        </ul>
                         <form action="{{$data->url}}" method="{{$data->method}}">
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("btn btn--base w-100 mt-3");
        })(jQuery);
    </script>
@endpush
