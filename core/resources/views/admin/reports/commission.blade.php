@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('TRX/Username')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form-control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    <option value="deposit_commission">@lang('Deposit Commission')</option>
                                    <option value="plan_subscribe_commission">@lang('Plan Subscribe Commission')</option>
                                    <option value="ptc_view_commission">@lang('Advertisement View Commission')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Levels')</label>
                                <select class="form-control" name="level">
                                    <option value="">@lang('Any')</option>
                                    @for($i = 1; $i <= $levels; $i++)
                                        <option value="{{ $i }}">{{__(ordinal($i))}} @lang('Level')</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Start date - End date')" autocomplete="off" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Type - Transaction')</th>
                                <th>@lang('Level - From')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($commissions as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                    <td data-label="@lang('User')">
                                        <span class="fw-bold">{{ $data->userTo->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->userTo->id) }}"><span>@</span>{{ $data->userTo->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Type - Transaction')">
                                        @if($data->type == 'deposit_commission')
                                            <span class="badge badge--success">@lang('Deposit')</span>
                                        @elseif($data->type == 'plan_subscribe_commission')
                                            <span class="badge badge--dark">@lang('Plan Subscribe')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Ads View')</span>
                                        @endif
                                        <br>
                                        {{__($data->trx)}}
                                    </td>
                                    <td data-label="@lang('Level - From')">
                                        <span class="fw-bold">{{__(ordinal($data->level))}}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->userFrom->id) }}"><span>@</span>{{ $data->userFrom->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <span class="fw-bold">{{__($general->cur_sym)}}{{getAmount($data->amount)}}</span>
                                    </td>
                                    <td data-label="@lang('Description')">
                                        {{__($data->details)}}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if($commissions->hasPages())
                <div class="card-footer">
                    {{ paginateLinks($commissions) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
  <script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
        $('[name=remark]').val('{{ request()->remark }}');
        $('[name=level]').val('{{ request()->level }}');
    })(jQuery)
  </script>
@endpush
