@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $kycInfo = getContent('kyc_info.content',true);
@endphp
<section class="cmn-section">
    <div class="container">
        <div class="row cmn-text">
            <div class="col-md-12 mb-4">
                @if(auth()->user()->kv == 0)
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                        <hr>
                        <p class="mb-0">{{ __($kycInfo->data_values->verification_content) }} <a
                                href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
                        </p>
                    </div>
                @elseif(auth()->user()->kv == 2)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                        <hr>
                        <p class="mb-0">{{ __($kycInfo->data_values->pending_content) }} <a
                                href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                    </div>
                @endif
            </div>
            <div class="col-md-6 mb-30">
                <div class="widget-two h-100 box--shadow2 b-radius--5 bg--white">
                    <i class="fas fa-dollar-sign overlay-icon text--primary"></i>
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="widget-two__content">
                        <h2 class="bal">{{ showAmount($user->balance) }} {{ $general->cur_text }}</h2>
                        <div class="d-flex flex-wrap justify-content-between position-relative">
                            <p>@lang('My Balance')</p>
                        <a href="{{ route('user.withdraw') }}"
                                class="btn cmn-btn">@lang('Withdraw Now') <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-md-6 mb-30">
                <div class="widget-two h-100 box--shadow2 b-radius--5 bg--white">
                    <i class="fas fa-tags overlay-icon text--primary"></i>
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="widget-two__content">
                        <h2>
                            @if($user->plan)
                                {{ __($user->plan->name) }} @if($user->expire_date < now()) (@lang('Expired')) @endif
                            @else
                                @lang('No Plan')
                            @endif
                        </h2>
                        <div class="d-flex flex-wrap justify-content-between position-relative">
                            <p>@lang('My Plan')</p>
                        <a href="{{ route('plans') }}" class="btn cmn-btn">@if($user->expire_date >= now()) @lang('Change Plan') @else @lang('Choose Plan') @endif <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @if($user->expire_date >= now())
                        <small class="text--danger">@lang('expire in') {{ \Carbon\Carbon::parse($user->expire_date)->format('Y-m-d') }}</small>
                        @endif
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-lg-8 col-md-12 mb-30">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Click & Earn Report')</h5>
                        <div id="apex-bar-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-30">
                <div class="row">
                    <div class="col-lg-12 col-md-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--primary">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="widget-three__content">
                                <h2>{{ showAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}</h2>
                                <p>@lang('Total Deposit')</p>
                                <a href="{{ route('user.deposit.history') }}" class="btn cmn-btn mt-2">@lang('Deposit History ')<i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--primary">
                                <i class="las la-university"></i>
                            </div>
                            <div class="widget-three__content">
                                <h2> {{ showAmount($user->withdrawals->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h2>
                                <p>@lang('Total Withdraw')</p>
                                <a href="{{ route('user.withdraw.history') }}" class="btn cmn-btn mt-2">@lang('Withdraw History ')<i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.ptc.clicks') }}" class="col-lg-6 col-md-12 mb-30">
                <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
                    <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-mouse-pointer"></i></div>
                    <div class="widget__content">
                        <p class="text-uppercase text-muted mb-0">@lang('Total Clicks')</p>
                        <h2 class="text--base font-weight-bold">{{ $user->clicks->count() }}</h2>
                    </div>
                    <div class="widget__arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            <a href="{{ route('user.ptc.index') }}" class="col-lg-6 col-md-12 mb-30">
                <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
                    <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-calendar-alt"></i></div>
                    <div class="widget__content">
                        <p class="text-uppercase text-muted mb-0">@lang('Remain clicks for today')</p>
                        <h2 class="text--base font-weight-bold">
                            {{ $user->daily_limit - $user->clicks->where('view_date',Date('Y-m-d'))->count() }}
                        </h2>
                    </div>
                    <div class="widget__arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            <a href="{{ route('user.ptc.clicks') }}" class="col-lg-6 col-md-12 mb-30">
                <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
                    <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-mouse-pointer"></i></div>
                    <div class="widget__content">
                        <p class="text-uppercase text-muted mb-0">@lang("Today's Clicks")</p>
                        <h2 class="text--base font-weight-bold">
                            {{ $user->clicks->where('view_date',Date('Y-m-d'))->count() }}
                        </h2>
                    </div>
                    <div class="widget__arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0)" class="col-lg-6 col-md-12 mb-30">
                <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
                    <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-stopwatch"></i></div>
                    <div class="widget__content">
                        <p class="text-uppercase text-muted mb-0">@lang('Next Reminder')</p>
                        <h2 class="text--base font-weight-bold timer" id="counter"></h2>
                    </div>
                    <div class="widget__arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
<script>
(function ($) {
    "use strict";
    // apex-bar-chart js
    var options = {
      series: [{
      name: 'Clicks',
      data: [
        @foreach($chart['click'] as $key => $click)
            {{ $click }},
        @endforeach
      ]
    }, {
      name: 'Earn Amount',
      data: [
            @foreach($chart['amount'] as $key => $amount)
                {{ $amount }},
            @endforeach
      ]
    }],
      chart: {
      type: 'bar',
      height: 580,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: [
      @foreach($chart['amount'] as $key => $amount)
                '{{ $key }}',
            @endforeach
    ],
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val
        }
      }
    }
    };
    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }
      createCountDown('counter', {{\Carbon\Carbon::tomorrow()->diffInSeconds()}});
})(jQuery);
</script>
@endpush
