@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card">
            <form action="" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if(@$cookie->data_values->status) checked @endif name="status">
                      </div>
                    </div>
                  </div>
                    <div class="form-group">
                      <label>@lang('Short Description')</label>
                        <textarea class="form-control" rows="5" required name="short_desc">{{ @$cookie->data_values->short_desc }}</textarea>
                    </div>
                    <div class="form-group">
                      <label>@lang('Description')</label>
                        <textarea class="form-control nicEdit" rows="10" name="description">@php echo @$cookie->data_values->description @endphp</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
