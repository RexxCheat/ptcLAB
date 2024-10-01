@extends($activeTemplate.'layouts.master')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label>@lang('Referral Link')</label>
                    <div class="input-group">
                        <input type="text" value="{{ route('home') }}?reference={{ $user->username }}"
                        class="form-control form-control-lg" id="referralURL"
                        readonly>
                        <button class="input-group-text copytext px-3 text--base" id="copyBoard"> <i class="fa fa-copy"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-30">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>@lang('Full Name')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Plan')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($refUsers as $log)
                                    <tr>
                                        <td data-label="@lang('Full Name')">{{ __($log->fullname) }}</td>
                                        <td data-label="@lang('User Name')">{{ __($log->username) }}</td>
                                        <td data-label="@lang('Email')">{{ $log->email }}</td>
                                        <td data-label="@lang('Phone')">{{ $log->mobile }}</td>
                                        <td data-label="@lang('Plan')">{{ __($log->plan ? $log->plan->name : "No Plan") }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"> {{ __($emptyMessage) }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{paginateLinks($refUsers)}}
            </div>
        </div>
    </div>
</section>
@endsection
@push('style')
<style type="text/css">
    .copytextDiv{
        border:1px solid #00000021;
        cursor: pointer;
    }
    #referralURL{
        border-right: 1px solid #00000021;
    }
    .bg-success-custom{
        background-color: #28a7456e!important;
    }
    .brd-success-custom{
        border: 1px dashed #28a745;
    }
</style>
@endpush
@push('script')
<script type="text/javascript">
    (function ($) {
        "use strict";
        $('#copyBoard').click(function(){
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        });
    })(jQuery);
</script>
@endpush
