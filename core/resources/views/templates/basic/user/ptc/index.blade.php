@extends($activeTemplate.'layouts.master')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="row gy-4 justify-content-center">

            @forelse($ads as $ad)
                <div class="col-xl-4 col-md-6">
                    <div class="card custom--card ptc-card ">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h6>{{ __($ad->title) }}</h6>
                                    <span class="fs--14px mt-2">@lang('Ads duration') : {{ $ad->duration }}s</span>
                                </div>
                                <div class="col-4 text-end">
                                    <h5 class="text--base">{{ $general->cur_sym }}{{ showAmount($ad->amount) }}</h5>
                                    <a href="{{ route('user.ptc.show',encrypt($ad->id.'|'.auth()->user()->id)) }}" target="_blank" class="btn fs--12px px-sm-3 px-2 py-1 btn--base mt-2">@lang('View Ad')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

            <div class="col-12">
                <div class="card custom--card ptc-card">
                    <div class="card-body">
                        <h2 class="text-center text--base">{{ __($emptyMessage) }}</h2>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

    </div>
</section>
@endsection
