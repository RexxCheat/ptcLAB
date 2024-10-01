@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($template->shortcodes as $shortcode => $key)
                                <tr>
                                    <th data-label="@lang('Short Code')">@php echo "{{". $shortcode ."}}"  @endphp</th>
                                    <td data-label="@lang('Description')">{{ __($key) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->

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
    </div>

    <form action="{{ route('admin.setting.notification.template.update',$template->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white">@lang('Email Template')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Subject')</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="@lang('Email subject')" name="subject" value="{{ $template->subj }}" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Status') <span class="text-danger">*</span></label>
                                    <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success"
                                       data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Send Email')"
                                       data-off="@lang("Don't Send")" name="email_status"
                                       @if($template->email_status) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Message') <span class="text-danger">*</span></label>
                                    <textarea name="email_body" rows="10" class="form-control nicEdit" placeholder="@lang('Your message using short-codes')">{{ $template->email_body }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white">@lang('SMS Template')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Status') <span class="text-danger">*</span></label>
                                    <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success"
                                       data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Send SMS')"
                                       data-off="@lang("Don't Send")" name="sms_status"
                                       @if($template->sms_status) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Message')</label>
                                    <textarea name="sms_body" rows="10" class="form-control" placeholder="@lang('Your message using short-codes')" required>{{ $template->sms_body }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn--primary w-100 h-45 mt-4">@lang('Submit')</button>
    </form>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.setting.notification.templates') }}" class="btn btn-sm btn-outline--primary"><i class="las la-undo"></i> @lang('Back') </a>
@endpush
