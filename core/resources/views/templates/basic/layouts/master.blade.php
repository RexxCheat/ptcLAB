@extends($activeTemplate.'layouts.app')
@section('panel')
    <div class="page-wrapper">
        @include($activeTemplate.'partials.user_header')
        @include($activeTemplate.'partials.breadcrumb')
        @yield('content')
    </div>
@endsection
