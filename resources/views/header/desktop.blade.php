{{-- Desktop header --}}
<div class="container desktop-header visible-md-block visible-lg-block">
    {{-- Banner --}}
    <div class="row">
        <div class="col-md-12">
            <div class="logo-container">
                <div class="button">
                    @auth
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('participant.participate') }}">
                                <img src="/images/challenge.png" class="img-fluid" style="width: 60%; height: auto;"/>
                            </a>
                        </div>
                    </div>
                    @endauth

                    @guest
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ sso_url('register') }}"><img src="/images/register.png" class="img-fluid" /></a>
                        </div>
                        {{-- <div class="col-md-6">
                            <a href="{{ route('school_registration.show') }}"><img src="/images/school_register.png"
                            class="img-fluid" /></a>
                    </div> --}}
                </div>
                @endguest
            </div>

            <div class="logo text-center">
                <a href="{{ route('home') }}">
                    <img src="/images/logo.png" class="img-fluid">
                </a>
            </div>

            <div class="prize-badge">
                {{-- <img src="/images/badge.png" class="img-fluid" style="width:80%;"> --}}
            </div>
        </div>
    </div>
</div>

{{-- Nav bar --}}
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="nav-bar-container">
            <div class="row fix-height">
                <div class="col-md-8">
                    <ul class="nav-list">
                        <li>
                            <a href="/">首頁</a>
                        </li>

                        <li>
                            <a href="/news">最新消息</a>
                        </li>

                        <li>
                            <a href="{{ route('information') }}">活動詳情</a>
                        </li>

                        {{-- <li>
                                <a href="{{ route('references') }}">參考資料</a>
                        </li> --}}

                        @if($global->rank_status==1)
                        <li>
                            <a href="{{ route('ranking') }}">排行榜</a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="col-md-4">
                    <ul class="nav-list">
                        @guest
                        <li>
                            <a href="{{ route('login') }}">登入</a> &nbsp; | &nbsp; <a
                                href="{{ sso_url('register') }}">登記</a>
                        </li>
                        @endguest

                        @auth
                        <li><a href="{{ route('competition.records') }}">我的成績</a></li>
                        <li>
                            <a href="{{ route('logout') }}">
                                登出
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
</div>