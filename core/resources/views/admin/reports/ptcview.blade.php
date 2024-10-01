@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('PTC Ad')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($ptcviews as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{ \Carbon\Carbon::parse($data->view_date)->format('Y-m-d') }}</td>
                                    <td data-label="@lang('PTC Ad')"> <a href="{{route('admin.ptc.edit',$data->ptc->id)}}">{{strLimit($data->ptc->title,20)}}</a></td>
                                    <td data-label="@lang('User')"><a href="{{ route('admin.users.detail', $data->user->id) }}">{{ $data->user->username }}</a></td>
                                    <td class="font-weight-bold" data-label="Amount">{{ getAmount($data->amount)}} {{$general->cur_text}} </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($ptcviews->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($ptcviews) }}
                </div>
                @endif
            </div><!-- card end -->
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="form-inline float-sm-end">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Username')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush
