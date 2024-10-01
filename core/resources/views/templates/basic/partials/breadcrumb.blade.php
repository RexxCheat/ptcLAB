@php
    $breadcrumb = getContent('breadcrumb.content',true);
@endphp
<section class="inner-page-hero bg_img" data-background="{{ getImage('assets/images/frontend/breadcrumb/'.$breadcrumb->data_values->image) }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="page-title">{{ __($pageTitle) }}</h2>
                <ul class="page-list">
                    <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                    <li class="active">{{ __($pageTitle) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
