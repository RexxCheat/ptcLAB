@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Compiled views will be cleared')</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Application cache will be cleared')</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Route cache will be cleared')</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Configuration cache will be cleared')</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Compiled services and packages files will be removed')</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span><i class="las la-check-double text--success"></i> @lang('Caches will be cleared')</span>
                    </li>
                </ul>
              </div>
              <div class="card-footer">
				<a href="{{ route('admin.system.optimize.clear') }}" class="btn btn--primary w-100 h-45">@lang('Click to clear')</a>
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
