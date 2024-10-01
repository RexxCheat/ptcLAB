<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="language  d-flex align-items-center">
                    <i class="las la-globe-europe"></i>
                    <select class="nic-select langSel">
                        @php
                            $langs = App\Models\Language::all();
                        @endphp
                        @foreach($langs as $lang)
                            <option value="{{ $lang->code }}" @if(Session::get('lang')===$lang->code) selected @endif>{{ __($lang->name) }}</option>
                        @endforeach
                    </select>
                </div>
            <div class="right text-sm-end text-center d-flex gap-2">
                @guest
                    <a href="{{ route('user.login') }}"><i class="las la-sign-in-alt"></i> @lang('Login')</a>
                    <a href="{{ route('user.register') }}"><i class="las la-user-plus"></i> @lang('Registration')</a>
                @else
                    <a href="{{ route('user.home') }}"><i class="las la-user-plus"></i> @lang('Dashboard')</a>
                @endguest
            </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"><span class="logo-icon"><i class="flaticon-fire"></i></span></a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                        <li class="menu_has_children"><a href="#0">@lang('Deposit')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.deposit') }}">@lang('Deposit Now')</a>
                                </li>
                                <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                            </ul>
                        </li>
                        <li class="menu_has_children"><a href="#0">@lang('Withdraw')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a>
                                </li>
                                <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('plans') }}">@lang('Plans')</a></li>
                        <li class="menu_has_children"><a href="#0">@lang('PTC')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.ptc.index') }}">@lang('Ads')</a></li>
                                @if($general->user_ads_post)
                                <li><a href="{{ route('user.ptc.ads') }}">@lang('My Ads')</a></li>
                                @endif
                                <li><a href="{{ route('user.ptc.clicks') }}">@lang('Clicks')</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>

                        <li class="menu_has_children"><a href="#0">@lang('Referral')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.commissions') }}">@lang('Commissions')</a>
                                </li>
                                <li><a href="{{ route('user.referred') }}">@lang('Referred Users')</a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu_has_children"><a href="#0">@lang('Account')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
                                <li><a href="{{ route('user.change.password') }}">@lang('Change
                                        Password')</a></li>
                                @if($general->balance_transfer)
                                <li><a href="{{ route('user.transfer.balance') }}">@lang('Balance Transfer')</a></li>
                                @endif
                                <li><a href="{{ route('ticket') }}">@lang('Support Ticket')</a></li>
                                <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor')</a>
                                </li>
                                <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
