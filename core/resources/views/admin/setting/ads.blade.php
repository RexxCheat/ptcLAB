@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card">
            <form action="" method="post">
                @csrf
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('User Ads Post')</label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if(@$general->user_ads_post) checked @endif name="user_ads_post">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Auto Approve')</label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if(@$general->ad_auto_approve) checked @endif name="ad_auto_approve">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('Script Ads')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>@lang('Ads Price')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="ad_price[script]" value="{{ @$general->ads_setting->ad_price->script }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Amount For User')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" value="{{ @$general->ads_setting->amount_for_user->script }}" name="amount_for_user[script]" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('Image Ads')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>@lang('Ads Price')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="ad_price[image]" value="{{ @$general->ads_setting->ad_price->image }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Amount For User')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount_for_user[image]" value="{{ @$general->ads_setting->amount_for_user->image }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('URL Ads')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>@lang('Ads Price')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="ad_price[url]" value="{{ @$general->ads_setting->ad_price->url }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Amount For User')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount_for_user[url]" value="{{ @$general->ads_setting->amount_for_user->url }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('Youtube Video Ads')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>@lang('Ads Price')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="ad_price[youtube]" value="{{ @$general->ads_setting->ad_price->youtube }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Amount For User')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount_for_user[youtube]" value="{{ @$general->ads_setting->amount_for_user->youtube }}" required>
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
    (function($){
    "use strict"
        $('[name=user_ads_post]').on('change', function () {
            var isCheck = $(this).prop('checked');
            if (isCheck == true) {
                $('[type=number]').removeAttr('readonly')
            } else {
                $('[type=number]').attr('readonly',true)
            }
        }).change();
    })(jQuery);
    </script>
@endpush
