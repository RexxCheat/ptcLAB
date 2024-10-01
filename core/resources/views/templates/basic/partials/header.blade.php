<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                    <div class="language d-flex align-items-center">
                        <i class="las la-globe-europe"></i>
                        <select class="nic-select langSel">
                            @php
                                $langs = App\Models\Language::all();
                            @endphp
                            @foreach($langs as $lang)
                                <option value="{{ $lang->code }}" @if(Session::get('lang')===$lang->code) selected
                                    @endif>{{ __($lang->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="right text-sm-end text-center">
                        @guest
                            <a href="{{ route('user.login') }}" class="me-2"><i class="las la-sign-in-alt"></i>
                                @lang('Login')</a>
                            <a href="{{ route('user.register') }}"><i class="las la-user-plus"></i>
                                @lang('Registration')</a>
                        @else
                            <a href="{{ route('user.home') }}"><i class="las la-user-plus"></i>
                                @lang('Dashboard')</a>
                        @endguest
                    </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{ asset('assets/images/logoIcon/logo.png') }}"
                        alt="site-logo"><span class="logo-icon"><i class="flaticon-fire"></i></span></a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="menu-toggle"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                        @foreach($pages as $page)
                            @if($page->slug != 'home' && $page->slug != 'blog' && $page->slug != 'contact')
                                <li><a href="{{ route('pages',$page->slug) }}">{{ __($page->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li><a href="{{ route('plans') }}">@lang('Plans')</a></li>
                        <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
                    </ul>
                    <div class="nav-right">
                        <a href="{{ route('contact') }}"
                            class="cmn-btn style--three">@lang('Contact')</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
