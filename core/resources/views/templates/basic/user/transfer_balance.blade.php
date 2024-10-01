@extends($activeTemplate.'layouts.master')
@section('content')
<div class="cmn-section">
    <div class="container">
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>@lang('Username')</label>
                    <input type="text" name="username" class="form-control checkUser">
                    <small class="text-danger usernameExist"></small>
                </div>
                <div class="form-group">
                    <label>@lang('Amount') <small class="text--success">( @lang('Charge'): {{ getAmount($general->bt_fixed) }} {{ $general->cur_text }} + {{ getAmount($general->bt_percent) }}% )</small></label>
                    <div class="input-group">
                        <input type="number" step="any" name="amount" value="{{ old('username') }}" class="form-control">
                        <span class="input-group-text">{{ $general->cur_text }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>@lang('Amount Will Cut From Your Account')</label>
                    <div class="input-group">
                        <input type="text" class="form-control calculation" readonly>
                        <span class="input-group-text">{{ $general->cur_text }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn--base w-100">@lang('Transfer')</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $('input[name=amount]').on('input',function(){
        var amo = parseFloat($(this).val());
        var calculation = amo + ( parseFloat({{ $general->bt_fixed }}) + ( amo * parseFloat({{ $general->bt_percent }}) ) / 100 );
        $('.calculation').val(calculation);
    });

    $('.checkUser').on('focusout',function(e){
        var url = '{{ route('user.checkUser') }}';
        var value = $(this).val();
        var token = '{{ csrf_token() }}';
        var data = {username:value,_token:token}
        $.post(url,data,function(response) {
            if(response.data != false){
                $(`.${response.type}Exist`).text('');
            }else{
                $(`.${response.type}Exist`).text(`${response.type} not found`);
            }
        });
    });
</script>
@endpush
