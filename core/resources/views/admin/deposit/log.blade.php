@extends('admin.layouts.app')

@section('panel')
<div class="row justify-content-center">
    @if(request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method') || request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method'))
        <div class="col-xxl-3 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--success has-link">
                <a href="{{ route('admin.deposit.successful') }}" class="item-link"></a>
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($successful) }}</h2>
                    <p class="text-white">@lang('Successful Deposit')</p>
                </div>
            </div><!-- widget-two end -->
        </div>
        <div class="col-xxl-3 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--6 has-link">
                <a href="{{ route('admin.deposit.pending') }}" class="item-link"></a>
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($pending) }}</h2>
                    <p class="text-white">@lang('Pending Deposit')</p>
                </div>
            </div><!-- widget-two end -->
        </div>
        <div class="col-xxl-3 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 has-link b-radius--5 bg--pink">
                <a href="{{ route('admin.deposit.rejected') }}" class="item-link"></a>
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($rejected) }}</h2>
                    <p class="text-white">@lang('Rejected Deposit')</p>
                </div>
            </div><!-- widget-two end -->
        </div>
        <div class="col-xxl-3 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 has-link b-radius--5 bg--dark">
                <a href="{{ route('admin.deposit.initiated') }}" class="item-link"></a>
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($initiated) }}</h2>
                    <p class="text-white">@lang('Initiated Deposit')</p>
                </div>
            </div><!-- widget-two end -->
        </div>
    @endif

    <div class="col-md-12">
        <div class="card b-radius--10">
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
                        @forelse($deposits as $deposit)
                            @php
                                $details = $deposit->detail ? json_encode($deposit->detail) : null;
                            @endphp
                            <tr>
                                <td data-label="@lang('Gateway | Transaction')">
                                     <span class="fw-bold"> <a href="{{ appendQuery('method',@$deposit->gateway->alias) }}">{{ __(@$deposit->gateway->name) }}</a> </span>
                                     <br>
                                     <small> {{ $deposit->trx }} </small>
                                </td>

                                <td data-label="@lang('Date')">
                                    {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                </td>
                                <td data-label="@lang('User')">
                                    <span class="fw-bold">{{ $deposit->user->fullname }}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ appendQuery('search',@$deposit->user->username) }}"><span>@</span>{{ $deposit->user->username }}</a>
                                    </span>
                                </td>
                                <td data-label="@lang('Amount')">
                                   {{ __($general->cur_sym) }}{{ showAmount($deposit->amount ) }} + <span class="text-danger" title="@lang('charge')">{{ showAmount($deposit->charge)}} </span>
                                    <br>
                                    <strong title="@lang('Amount with charge')">
                                    {{ showAmount($deposit->amount+$deposit->charge) }} {{ __($general->cur_text) }}
                                    </strong>
                                </td>
                                <td data-label="@lang('Conversion')">
                                   1 {{ __($general->cur_text) }} =  {{ showAmount($deposit->rate) }} {{__($deposit->method_currency)}}
                                    <br>
                                    <strong>{{ showAmount($deposit->final_amo) }} {{__($deposit->method_currency)}}</strong>
                                </td>
                                <td data-label="@lang('Status')">
                                    @php echo $deposit->statusBadge @endphp
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.deposit.details', $deposit->id) }}"
                                       class="btn btn-sm btn-outline--primary ms-1">
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
            @if ($deposits->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($deposits) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>


@endsection


@push('breadcrumb-plugins')
    @if(!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method'))
        <form action="" method="GET">
            <div class="form-inline float-sm-end mb-2 ms-0 ms-xl-2 ms-lg-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Trx number/Username')" value="{{ request()->search ?? '' }}">
                    <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="form-inline float-sm-end">
                <div class="input-group">
                    <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('Start date - End date')" autocomplete="off" value="{{ request()->date }}">
                    <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush


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
