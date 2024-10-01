@extends('admin.layouts.app')
@section('panel')
<div class="row">
	<div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive table-responsive--sm">
                    <table class=" table align-items-center table--light">
                        <thead>
                        <tr>
                            <th>@lang('Short Code') </th>
                            <th>@lang('Description')</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <tr>
                            <td data-label="@lang('Short Code')">@{{fullname}}</td>
                            <td data-label="@lang('Description')">@lang('Full Name of User')</td>
                        </tr>
                        <tr>
                            <td data-label="@lang('Short Code')">@{{username}}</td>
                            <td data-label="@lang('Description')">@lang('Username of User')</td>
                        </tr>
                        <tr>
                            <td data-label="@lang('Short Code')">@{{message}}</td>
                            <td data-label="@lang('Description')">@lang('Message')</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <h6 class="mt-4 mb-2">@lang('Global Short Codes')</h6>
        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive table-responsive--sm">
                    <table class=" table align-items-center table--light">
                        <thead>
                        <tr>
                            <th>@lang('Short Code') </th>
                            <th>@lang('Description')</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($general->global_shortcodes as $shortCode => $codeDetails)
                        <tr>
                            <td data-label="@lang('Short Code')">@{{@php echo $shortCode @endphp}}</td>
                            <td data-label="@lang('Description')">{{ __($codeDetails) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card mt-5">
            <div class="card-body">
                <form action="{{ route('admin.setting.notification.global.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold">@lang('Email Sent From') </label>
                                <input type="text" class="form-control " placeholder="@lang('Email address')" name="email_from" value="{{ $general->email_from }}" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold">@lang('Email Body') </label>
                                <textarea name="email_template" rows="10" class="form-control  nicEdit" placeholder="@lang('Your email template')">{{ $general->email_template }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold">@lang('SMS Sent From') </label>
                                <input class="form-control" placeholder="@lang('SMS Sent From')" name="sms_from" value="{{ $general->sms_from }}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold">@lang('SMS Body') </label>
                                <textarea class="form-control" rows="4" placeholder="@lang('SMS Body')" name="sms_body" required>{{ $general->sms_body }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn w-100 btn--primary h-45">@lang('Submit')</button>
                </form>
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection
