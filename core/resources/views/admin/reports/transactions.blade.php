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
                            <label>@lang('Type')</label>
                            <select name="type" class="form-control">
                                <option value="">@lang('All')</option>
                                <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label>@lang('Remark')</label>
                            <select class="form-control" name="remark">
                                <option value="">@lang('Any')</option>
                                @foreach($remarks as $remark)
                                <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                @endforeach
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
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('TRX')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="fw-bold">{{ $trx->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ appendQuery('search',$trx->user->username) }}"><span>@</span>{{ $trx->user->username }}</a> </span>
                                    </td>

                                    <td data-label="@lang('Trx')">
                                        <strong>{{ $trx->trx }}</strong>
                                    </td>

                                    <td data-label="@lang('Transacted')">
                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                    </td>

                                    <td data-label="@lang('Amount')" class="budget">
                                        <span class="fw-bold @if($trx->trx_type == '+')text--success @else text--danger @endif">
                                            {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text }}
                                        </span>
                                    </td>

                                    <td data-label="@lang('Post Balance')" class="budget">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </td>

                                    <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
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
        @if($transactions->hasPages())
        <div class="card-footer py-4">
            {{ paginateLinks($transactions) }}
        </div>
        @endif
    </div><!-- card end -->
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
    })(jQuery)
  </script>
@endpush
