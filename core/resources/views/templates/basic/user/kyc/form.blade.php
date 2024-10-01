@extends($activeTemplate.'layouts.master')
@section('content')
<div class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">@lang('KYC Form')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <x-viser-form identifier="act" identifierValue="kyc"></x-viser-form>

                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
