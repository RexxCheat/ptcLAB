@extends('admin.layouts.app')

@section('panel')
<div class="row justify-content-center">
    @if(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.method') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals.method'))
    <div class="col-xl-4 col-sm-6 mb-30">
        <div class="widget-two box--shadow2 has-link b-radius--5 bg--success">
            <a href="{{ route('admin.withdraw.approved') }}" class="item-link"></a>
            <div class="widget-two__content">
                <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($successful) }}</h2>
                <p class="text-white">@lang('Approved Withdrawals')</p>
            </div>
        </div><!-- widget-two end -->
    </div>
    <div class="col-xl-4 col-sm-6 mb-30">
        <div class="widget-two box--shadow2 has-link b-radius--5 bg--6">
            <a href="{{ route('admin.withdraw.pending') }}" class="item-link"></a>
            <div class="widget-two__content">
                <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($pending) }}</h2>
                <p class="text-white">@lang('Pending Withdrawals')</p>
            </div>
        </div><!-- widget-two end -->
    </div>
    <div class="col-xl-4 col-sm-6 mb-30">
        <div class="widget-two box--shadow2 b-radius--5 has-link bg--pink">
            <a href="{{ route('admin.withdraw.rejected') }}" class="item-link"></a>
            <div class="widget-two__content">
                <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($rejected) }}</h2>
                <p class="text-white">@lang('Rejected Withdrawals')</p>
            </div>
        </div><!-- widget-two end -->
    </div>
    @endif
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">

                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Gateway | Transaction')</th>
                                <th>@lang('Initiated')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Conversion')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $withdraw)
                            @php
                            $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                            @endphp
                            <tr>
                                <td data-label="@lang('Gateway | Transaction')">
                                    <span class="fw-bold"><a href="{{ appendQuery('method',@$withdraw->method->id) }}"> {{ __(@$withdraw->method->name) }}</a></span>
                                    <br>
                                    <small>{{ $withdraw->trx }}</small>
                                </td>
                                <td data-label="@lang('Initiated')">
                                    {{ showDateTime($withdraw->created_at) }} <br>  {{ diffForHumans($withdraw->created_at) }}
                                </td>

                                <td data-label="@lang('User')">
                                    <span class="fw-bold">{{ $withdraw->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ appendQuery('search',@$withdraw->user->username) }}"><span>@</span>{{ $withdraw->user->username }}</a> </span>
                                </td>


                                <td data-label="@lang('Amount')">
                                   {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }} - <span class="text-danger" title="@lang('charge')">{{ showAmount($withdraw->charge)}} </span>
                                    <br>
                                    <strong title="@lang('Amount after charge')">
                                    {{ showAmount($withdraw->amount-$withdraw->charge) }} {{ __($general->cur_text) }}
                                    </strong>

                                </td>

                                <td data-label="@lang('Conversion')">
                                   1 {{ __($general->cur_text) }} =  {{ showAmount($withdraw->rate) }} {{ __($withdraw->currency) }}
                                    <br>
                                    <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}</strong>
                                </td>



                                <td data-label="@lang('Status')">
                                    @php echo $withdraw->statusBadge @endphp
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                        <i class="la la-desktop"></i> @lang('Details')
                                    </a>
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
        @if ($withdrawals->hasPages())
        <div class="card-footer py-4">
            {{ paginateLinks($withdrawals) }}
        </div>
        @endif
    </div><!-- card end -->
</div>
</div>

@endsection




@push('breadcrumb-plugins')
    <form action="" method="GET">
        <div class="form-inline float-sm-end mb-2 ms-0 ms-xl-2 ms-lg-0">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Trx number/Username')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="form-inline float-sm-end">
            <div class="input-group">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('Start Date - End date')" autocomplete="off" value="{{ request()->date }}">
                <input type="hidden" name="method" value="{{ @$method->id }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@push('script-lib')
<script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
<script>
    (function($){
        'use strict';
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>
@endpush
