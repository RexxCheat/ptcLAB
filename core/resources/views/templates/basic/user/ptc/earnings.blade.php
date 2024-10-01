@extends($activeTemplate.'layouts.master')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive--sm">
                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                              <th scope="col">@lang('Date')</th>
                              <th scope="col">@lang('Total Click')</th>
                              <th scope="col">@lang('Total Earn')</th>
                          </tr>
                      </thead>
                      <tbody class="list">
                           @forelse($viewads as $view)
                           <tr>
                                <td data-label="@lang('Date')"> {{ showDateTime($view->date, 'd M, Y') }} </td>
                                <td data-label="@lang('Total Clicks')">{{ $view->total_clicks }}</td>
                                <td data-label="@lang('Total Earned')">
                                    {{ showAmount($view->total_earned) }} {{ $general->cur_text }}
                                </td>
                            </tr>
                          @empty
                              <tr>
                                  <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
        {{paginateLinks($viewads)}}
    </div>
</section>
@endsection
