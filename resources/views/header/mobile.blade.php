<div class="navbar navbar-default navbar-fixed-top mobile-header visible-sm-block visible-xs-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 px-0">
                <div class="banner-container">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="nav-icon">
                                <div class="navbar-toggle collapsed mobile-nav-taggle" id="mobile-nav-taggle"
                                    data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-9 text-right">
                            <div class="button">
                                @guest
                                {{-- <div class="row">
                                    <div class="col-xs-12">
                                        <a href="{{ route('school_registration.show') }}"><img src="/images/school_register.png" class="img-fluid" /></a>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a href="{{ sso_url('register') }}"><img src="/images/register.png" class="img-fluid" /></a>
                                    </div>
                                </div>
                                @endguest
                
                                @auth
                                <a href="{{ route('participant.participate') }}"><img src="/images/challenge.png" class="img-fluid" /></a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Side Menu --}}
        <div id="mobile-menu" class="mobile-nav visible-xs clearfix hide-nav">
            <div>
                <div class="left-top clearfix"></div>

                @auth
                <div class="Looop">
                    <ul>
                        {{-- <li><a href="{{ route('user') }}">個人資料</a></li> --}}
                        <li><a href="{{ route('competition.records') }}">我的成績</a></li>
                        <li>
                            <a href="{{ route('logout') }}">登出</a>
                        </li>
                    </ul>
                </div>
                @endauth

                @guest
                <div class="Looop">
                    <ul>
                        <li>
                            <a href="{{ route('login') }}">登入</a>
                            | 
                            <a href="{{ sso_url('register') }}">登記</a>
                        </li>
                    </ul>
                </div>
                @endguest

                <ul>
                    <li>
                        <div class="title">
                            <h3><a href="/">{{trans('home.main_menu.homepage')}}</a></h3>
                        </div>
                    </li>
                    <li>
                        <div class="title">
                            <h3><a href="/news">{{trans('home.main_menu.latest_news')}}</a></h3>
                    </li>
                    <li>
                        <div class="title">
                            <h3>
                                <a href="{{ route('information') }}">{{trans('home.main_menu.game_intro')}}</a>
                            </h3>
                        </div>
                    </li>
                    {{-- <li>
                        <div class="title">
                            <h3><a href="{{ route('references') }}">{{trans('home.main_menu.ref_info')}}</a></h3>
                        </div>
                    </li> --}}
                    
                    @if($global->rank_status==1)
                    <li>
                        <div class="title">
                            <h3><a href="{{ route('ranking') }}">{{trans('home.main_menu.ranking')}}</a></h3>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
            <div id="tach"></div>
        </div>
    </div>
</div>

<div class="container visible-xs">
    {{-- Mobile nav bar --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="mobile-nav-bar-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="/">首頁</a></div>
                    <div class="swiper-slide"><a href="{{ route('news') }}">最新消息</a></div>
                    <div class="swiper-slide"><a href="{{ route('information') }}">活動詳情</a></div>
                    {{-- <div class="swiper-slide"><a href="{{ route('references') }}">參考資料</a></div> --}}
                    @if($global->rank_status==1)
                        <div class="swiper-slide"><a href="{{ route('ranking') }}">排行榜</a></div>
                    @endif

                    @guest
                    <div class="swiper-slide"><a href="{{ route('login') }}">登入</a></div>
                    <div class="swiper-slide"><a href="{{ sso_url('register') }}">登記</a></div>
                    @endguest

                    @auth
                    <div class="swiper-slide"><a href="{{ route('competition.records') }}">我的成績</a></div>
                    <div class="swiper-slide">
                        <a href="{{ route('logout') }}">登出</a>
                    </div>
                    @endauth
                </div>
                    <!-- Add Scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </div>
</div>