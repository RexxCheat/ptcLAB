@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('PHP Version')</span>
                        <span>{{ $currentPHP }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Server Software')</span>
                        <span>{{ @$serverDetails['SERVER_SOFTWARE'] }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Server IP Address')</span>
                        <span>{{ @$serverDetails['SERVER_ADDR'] }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Server Protocol')</span>
                        <span>{{ @$serverDetails['SERVER_PROTOCOL'] }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('HTTP Host')</span>
                        <span>{{ @$serverDetails['HTTP_HOST'] }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Server Port')</span>
                        <span>{{ @$serverDetails['SERVER_PORT'] }}</span>
                    </li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                </ul>
              </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
  .list-group-item span{
    font-size: 22px !important;
    padding: 8px 0px
  }
</style>
@endpush
