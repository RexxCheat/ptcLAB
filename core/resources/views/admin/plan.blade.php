@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Limit/Day')</th>
                            <th scope="col">@lang('Validity')</th>
                            <th scope="col">@lang('Referral Commission')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td data-label="@lang('Name')">{{$plan->name}}</td>
                            <td data-label="@lang('Price')" class="font-weight-bold">{{ showAmount($plan->price) }} {{$general->cur_text}}</td>

                            <td data-label="@lang('Limit/Day')">{{ $plan->daily_limit}} @lang('PTC')</td>
                            <td data-label="@lang('Validity')">{{ $plan->validity}} @lang('Day')</td>
                            <td data-label="@lang('Referral Commission')">@lang('up to') <span class="font-weight-bold text-primary px-3">{{ $plan->ref_level }} </span>@lang('level')</td>
                            <td data-label="@lang('Status')">
                                @if($plan->status == 1)
                                    <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                    <span class="badge badge--danger">
                                        @lang('Inactive')
                                    </span>
                                @endif
                            </td>
                            <td data-label="@lang('Action')">
                                <button class="btn btn-outline--primary btn-sm planBtn" data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-price="{{ getAmount($plan->price) }}" data-daily_limit="{{ $plan->daily_limit }}" data-validity="{{ $plan->validity }}" data-status="{{ $plan->status }}" data-ref_level="{{ $plan->ref_level}}" data-act="Edit">
                                    <i class="la la-pencil"></i> @lang('Edit')
                                </button>
                            </td>
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
    </div>
  </div>
</div>

<div class="modal fade" id="planModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"><span class="act"></span> @lang('Subscription Plan')</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
            </div>
            <form action="{{ route('admin.plan.save') }}" method="post">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('Name') </label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Plan Name')" required>
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('Price') </label>
                        <div class="input-group">
                            <input type="text" class="form-control has-append" name="price" placeholder="@lang('Price of Plan')" required>
                            <div class="input-group-text">{{ $general->cur_text }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Daily Ad Limit')</label>
                        <input type="number" class="form-control" name="daily_limit" placeholder="@lang('Daily Ad Limit')" required>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Validity')</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="validity" placeholder="@lang('Validity')" required>
                            <div class="input-group-text">@lang('Days')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details">@lang('Referral Commission') </label>
                        <select name="ref_level" class="form-control" required>
                            <option value="0"> @lang('NO Referral Commission')</option>
                            @for($i = 1; $i <= $levels; $i++)
                            <option value="{{$i}}"> @lang('Up to') {{$i}}  @lang('Level')</option>
                            @endfor
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="status">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm planBtn" data-id="0" data-act="Add" data-bs-toggle="modal" data-bs-target="#planModal"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('.planBtn').on('click', function() {
            var modal = $('#planModal');
            modal.find('.act').text($(this).data('act'));
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=daily_limit]').val($(this).data('daily_limit'));
            modal.find('input[name=validity]').val($(this).data('validity'));
            modal.find('input[name=status]').bootstrapToggle($(this).data('status') == 1 ? 'on' : 'off');
            modal.find('select[name=ref_level]').val($(this).data('ref_level'));
            if($(this).data('id') == 0){
                modal.find('form')[0].reset();
            }
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
