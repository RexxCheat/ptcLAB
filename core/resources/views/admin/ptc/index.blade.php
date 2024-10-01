@extends('admin.layouts.app')
@section('panel')
<div class="row">
  <div class="col-md-12">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Title')</th>
                            <th scope="col">@lang('Posted By')</th>
                            <th scope="col">@lang('Type')</th>
                            <th scope="col">@lang('Duration')</th>
                            <th scope="col">@lang('Maximum View')</th>
                            <th scope="col">@lang('Viewed')</th>
                            <th scope="col">@lang('Remain')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ads as $ptc)
                            <tr>
                                <td data-label="@lang('Title')">{{strLimit($ptc->title,20)}}</td>
                                <td data-label="@lang('Posted By')">
                                    @if($ptc->user)
                                        <span class="fw-bold">{{ $ptc->user->fullname }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail',$ptc->user_id) }}"><span>@</span>{{ $ptc->user->username }}</a>
                                        </span>
                                    @else
                                        <span class="fw-bold">@lang('Admin')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Type')">
                                    @php echo $ptc->typeBadge @endphp
                                </td>
                                <td data-label="@lang('Duration')">{{$ptc->duration}} @lang('Sec')</td>
                                <td data-label="@lang('Maximum View')">{{$ptc->max_show}}</td>
                                <td data-label="@lang('Viewed')">{{$ptc->showed}}</td>
                                <td data-label="@lang('Remain')">{{$ptc->remain}}</td>


                                <td data-label="@lang('Amount')" class="font-weight-bold">{{ showAmount($ptc->amount) }} {{$general->cur_text}}</td>

                                <td data-label="@lang('Status')">
                                    @php echo $ptc->statusBadge @endphp
                                </td>
                                <td data-label="@lang('Action')"><a class="btn btn-outline--primary btn-sm" href="{{route('admin.ptc.edit',$ptc->id)}}"><i class="la la-pen"></i> @lang('Edit')</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($ads->hasPages())
        <div class="card-footer">
            {{ paginateLinks($ads) }}
        </div>
        @endif
    </div>
  </div>
</div>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.ptc.create') }}" class="btn btn-outline--primary btn-sm"><i class="las la-plus"></i> @lang('Add New')</a>
@endpush
