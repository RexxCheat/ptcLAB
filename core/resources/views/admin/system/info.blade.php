@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <span>{{ systemDetails()['name'] }} @lang('Version')</span>
                    <span>{{ systemDetails()['version'] }}</span>
                  </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('ViserAdmin Version')</span>
                        <span>{{ systemDetails()['build_version'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Laravel Version')</span>
                        <span>{{ $laravelVersion }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <span>@lang('Timezone')</span>
                        <span>{{ @$timeZone }}</span>
                    </li>
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
