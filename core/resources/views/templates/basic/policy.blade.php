@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="ptb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @php echo $policy->data_values->details @endphp
            </div>
        </div>
    </div>
</div>
@endsection
