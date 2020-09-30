@php
$nav = isset($nav) ? $nav : '99999';
$page = isset($page) ? $page : 'other';
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="header clearfix pcheader">
                <div class="header-container">
                    <div class="button">
                        @auth
                            <a href="{{ route('participant.participate') }}"><img src="/home/img/challenge.png" /></a>
                        @endauth

                        @guest
                            <a href="{{ route('register') }}"><img src="/home/img/register.png" /></a>
                        @endguest
                    </div>
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="/home/img/logo.png"></a>
                    </div>

                    <div class="prize-badge">
                        <img src="/home/img/badge.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="mobile-header">
                <div class="nav-btn visible-xs fexd">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed mobile-nav-taggle" id="mobile-nav-taggle"
                            data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <div class="logos">
                            @guest
                            <div>
                                <a href="{{ route('register') }}"><img src="/home/img/register.png" class="logo" /></a>
                            </div>
                            @endguest

                            @auth
                            <div>
                                <a href="{{ route('participant.participate') }}"><img src="/home/img/challenge.png" /></a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                {{-- 側欄 --}}
                <div id="mobile-menu" class="mobile-nav visible-xs clearfix hide-nav">
                    <div>
                        <div class="left-top clearfix">
                            <button type="button" class="navbar-toggle collapsed mobile-nav-taggle left-top-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        @auth

                        <div class="Looop">
                            <ul>
                                <li><a href="{{ route('user') }}">個人資料</a></li>
                                <li><a href="{{ route('competition.records') }}">比賽記錄</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        登出
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endauth

                        @guest
                        <div class="Looop">
                            <ul>
                                <li>
                                    <a href="{{url('/login')}}">{{trans('home.main_menu.login')}}</a><a> / </a><a
                                        href="{{ route('register') }}">{{trans('home.registered.registered')}}</a>

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
                            <li>
                                <div class="title">
                                    <h3><a href="{{ route('references') }}">{{trans('home.main_menu.ref_info')}}</a></h3>
                                </div>
                            </li>
                            @guest
                            <li>
                                <div class="title">
                                    <h3><a href="{{ route('register') }}">{{trans('home.main_menu.student_reg')}}</a></h3>
                                </div>
                            </li>
                            @endguest
                            @if($global->rank_status==1)
                            <li>
                                <div class="title">
                                    <h3><a href="{{ route('ranking') }}">{{trans('home.main_menu.ranking')}}</a></h3>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="nav-top"></div>

            <div class="nav nav-header">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="nav-list">
                            <li>
                                <a href="/">首頁</a>
                                <div class="line"></div>
                            </li>
                            <li>
                                <a href="/news">最新消息</a>
                                <div class="line"></div>
                            </li>
                            <li>
                                <a href="{{ route('information') }}">活動詳情</a>
                                <div class="line"></div>
                            </li>
                            <li>
                                <a href="{{ route('references') }}">參考資料</a>
                                <div class="line"></div>
                            </li>
        
                            @guest
                            <li>
                                <a href="{{ route('register') }}">學生登記</a>
                                <div class="line"></div>
                            </li>
                            @endguest
                            
                            {{-- @if($global->rank_status==1) --}}
                            <li>
                                <a href="{{ route('ranking') }}">排行榜</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </div>

                    <div class="col-md-4" >
                        <ul class="nav-list">
                        @guest
                            <li>
                                <a href="/login">登入</a>
                            </li>
                            @endguest
        
                            @auth
                            <li><a href="{{ route('competition.records') }}">我的成績</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                登出
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>