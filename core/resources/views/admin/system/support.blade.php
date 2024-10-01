@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card b-radius--10 ">
              <div class="card-body text-center">
                <h3>@lang('To keep our support system efficient and seamless and to keep your data safe and secure, we\'ve developed an easy to use support portal for you. We are now using that centralized system to provide support.')</h3>
              </div>
              <div class="card-footer">
                <a href="https://viserlab.com/support" target="_blank" class="btn btn--primary h-45 w-100">@lang('Get Support')</a>
              </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
  td{

    font-size: 22px !important;
  }
  .table td {
      white-space: nowrap;
  }
</style>
@endpush
