@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form role="form" method="POST" action="{{ route("admin.ptc.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       <div class="form-group col-md-8">
                            <label>@lang('Title of the Ad')</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="@lang('Title')" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="@lang('User will get ...')" required>
                                <div class="input-group-text"> {{ $general->cur_text }} </div>
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label>@lang('Duration')</label>
                            <div class="input-group">
                                <input type="number" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="@lang('Duration')" required>
                                <div class="input-group-text">@lang('SECONDS')</div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label>@lang('Maximum Show')</label>
                            <div class="input-group">
                                <input type="number" name="max_show" class="form-control" value="{{ old('max_show') }}" placeholder="@lang('Maximum Show') " required>
                                <div class="input-group-text">@lang('Times')</div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label>@lang('Status')</label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="Active" data-off="Inactive" name="status">
                        </div>
                    </div>

                    <div class="row pt-5 mt-5 border-top">
                        <div class="form-group col-md-4">
                            <label for="ads_type">@lang('Advertisement Type')</label>
                            <select class="form-control" id="ads_type" name="ads_type" required>
                                <option value="1" {{ old('ads_type')==1?'selected':'' }}>@lang('Link / URL')</option>
                                <option value="2" {{ old('ads_type')==2?'selected':'' }}>@lang('Banner / Image')</option>
                                <option value="3" {{ old('ads_type')==3?'selected':'' }}>@lang('Script / Code')</option>
                                <option value="4" {{ old('ads_type')==4?'selected':'' }}>@lang('Youtube Embeded Link')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8" id="websiteLink">
                            <label>@lang('Link')</label>
                            <input type="text" name="website_link" class="form-control" value="{{ old('website_link') }}" placeholder="@lang('http://example.com')">
                        </div>
                        <div class="form-group col-md-8" id="youtube">
                            <label>@lang('Youtube Embeded Link')</label>
                            <input type="text" name="youtube" class="form-control" value="{{ old('youtube') }}" placeholder="@lang('https://www.youtube.com/embed/your_code')">
                        </div>
                        <div class="form-group col-md-8 d-none" id="bannerImage">
                            <label>@lang('Banner')</label>
                            <input type="file" class="form-control"  name="banner_image">
                        </div>
                        <div class="form-group col-md-8 d-none" id="script">
                            <label>@lang('Script')</label>
                            <textarea  name="script" class="form-control">{{ old('script') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12 mt-3">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.ptc.index') }}" class="btn btn-outline--primary btn-sm"><i class="las la-undo"></i> @lang('Back') </a>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('#ads_type').change(function(){
            var adType = $(this).val();
            if (adType == 1) {
                $("#websiteLink").removeClass('d-none');
                $("#bannerImage").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if (adType == 2) {
                $("#bannerImage").removeClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if(adType == 3) {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").removeClass('d-none');
                $("#youtube").addClass('d-none');
            } else {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").removeClass('d-none');
            }
        }).change();
    })(jQuery);
</script>
@endpush
