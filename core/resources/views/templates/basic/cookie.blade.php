@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            echo $cookie->data_values->description
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
