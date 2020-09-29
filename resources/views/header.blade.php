@php
$nav = isset($nav) ? $nav : '99999';
$page = isset($page) ? $page : 'other';
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            {{-- pc端頭部，判斷pc還是手機 --}}
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
                        <img src="/home/img/logo.png">
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
            {{-- 手機端頭部，判斷pc還是手機 --}}
            {{-- 手机导航栏侧滑 --}}
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
                            {{-- 用戶未登入 --}}
                            @guest
                            <div>
                                <a href="{{ route('register') }}"><img src="/home/img/register.png" class="logo" /></a>
                            </div>
                            @endguest

                            {{-- 用戶已登入 --}}
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
                                <li>
                                    <a> Hi {{$user_data->name}}</a> /
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{trans('home.main_menu.drop_out')}}
                                    </a>
                                </li>
                                <li>
                                <li><a href="{{ route('user') }}">個人資料</a></li>
                                <li><a href="{{ route('competition.records') }}">比賽記錄</a></li>
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
                        <div class="wlogo">
                            <a href="https://www.facebook.com/looop.hk/" target="blank">
                                <span>{{lang('Looop Facebook專頁')}}</span>
                                <img src="/home/img/facebook.png" />
                            </a>
                        </div>
                        <div class="wlogo">
                            <a href="https://www.facebook.com/shifiles/" target="blank">
                                <span>{{lang('史檔 Facebook專頁')}}</span>
                                <img src="/home/img/facebook.png" />
                            </a>
                        </div>
                    </div>
                    <div id="tach"></div>
                </div>
            </div>

            <div class="nav-top"></div>

            <div class="nav nav-header">
                <ul class="clearfix">
                    <li>
                        <a href="/" class="@if($page == 'index') active @endif">{{trans('home.main_menu.homepage')}}</a>
                        <div class="line"></div>
                    </li>
                    <li>
                        <a href="/news" class="@if($page == 'news') active @endif">{{trans('home.main_menu.latest_news')}}</a>
                        <div class="line"></div>
                    </li>
                    <li>
                        <a href="{{ route('information') }}"
                            class="@if($page == 'information') active @endif">{{trans('home.main_menu.game_intro')}}</a>
                        <div class="line"></div>
                    </li>
                    <li>
                        <a href="{{ route('references') }}"
                            class="@if($page == 'reference') active @endif">{{trans('home.main_menu.ref_info')}}</a>
                        <div class="line"></div>
                    </li>

                    @guest
                    <li>
                        <a href="{{ route('register') }}"
                            class="@if($nav==4)active @endif">{{trans('home.main_menu.student_reg')}}</a>
                        <div class="line"></div>
                    </li>
                    @endguest
                    
                    @if($global->rank_status==1)
                    <li>
                        <a href="{{ route('ranking') }}"
                            class="@if($nav==5)active @endif">{{trans('home.main_menu.ranking')}}</a>
                    </li>
                    @endif

                    @guest
                    <div>
                        <span>
                            <a href="/login" style="color: #FFF462">{{trans('home.main_menu.login')}}</a>
                        </span>
                    </div>
                    @endguest

                    @auth
                    <li>
                        <div class="loginactive">
                            <span>Hi <span>{{$user_data->name}}</span></span>
                            <input type="hidden" name="userId" value="{{$user_data->id}}">
                            <span>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{trans('home.main_menu.drop_out')}}
                                </a>
                            </span>
                            <ul>
                                <li><a href="{{ route('user') }}">個人資料</a></li>
                                <li><a href="{{ route('competition.records') }}">比賽記錄</a></li>
                            </ul>
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>