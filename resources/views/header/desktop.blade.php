{{-- Desktop header --}}
<div class="container desktop-header visible-md-block visible-lg-block">
    {{-- Banner --}}
    <div class="row">
        <div class="col-md-12">
            <div class="logo-container">
                <div class="button">
                    @auth
                    <a href="{{ route('participant.participate') }}"><img src="/images/challenge.png" /></a>
                    @endauth

                    @guest
                    <a href="{{ route('register') }}"><img src="/images/register.png" /></a>
                    @endguest
                </div>
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="/images/logo.png"></a>
                </div>

                <div class="prize-badge">
                    <img src="/images/badge.png">
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

                            <li>
                                <a href="{{ route('references') }}">參考資料</a>
                            </li>

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
                                <a href="/login">登入</a> &nbsp; | &nbsp; <a href="{{ route('register') }}">登記</a>
                            </li>
                            @endguest

                            @auth
                            <li><a href="{{ route('competition.records') }}">我的成績</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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