@extends('layouts.app')

@section('style')
<style>
    .section .section-right .loading {

        height: 52px;
    }

    a {
        font-size: 16px
    }

    a:link {
        text-decoration: none;
    }

    .section .section-top .section-other {
        margin-top: 0 !important;
    }

    /*.section .banner{
        margin-top: 14px;
    }*/
    @media (max-width: 767px) {
        .section .section-right h2,
        .section .section-right h2 a {
            display: none;
        }
    }

    .clearfix p {
        word-wrap: break-word;
        width: 100%;
    }

    .hot-content h4 {
        word-wrap: break-word;
        width: 100%;
    }

    .section .section-right .hot-content>div>div:nth-child(2) {
        overflow: visible;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="section clearfix">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-middle section-idxmid">
                        <div>
                            @if(Agent::isMobile())
                            @include('home.comm.header')
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
                    <div class="section-right">
                        <h2>{{trans('home.latest_news_blk.title')}}</h2>

                        @foreach($newsList as $news)
                        <div class="hot-content disnone">
                            <h4><a href="{{ route('news.detail', ['slug' =>$news->id]) }}">{{$news->title}}</a></h4>
                            <div class="clearfix">
                                <div class="bgColor">
                                    @if($news->cover_image)
                                    <a href="{{ route('news.detail', ['slug' =>$news->id]) }}"><img
                                            src="{{$img_url.$news->cover_image}}" /></a>
                                    @endif
                                </div>
                                <div>
                                    <p>{{$news->excerpt}}</p>
                                </div>
                            </div>
                            <div class="more"><a
                                    href="{{ route('news.detail', ['slug' =>$news->id]) }}">{{trans('home.global.more')}}...</a>
                            </div>
                            {{-- <div class="star">
                                    <img src="/home/img/star.png"/>
                                </div> --}}
                        </div>
                        @endforeach

                        <div class="loading">
                            {{$newsList->links('common.pagination')}}
                        </div>

                        {{-- 手機版信息,要判斷是pc還是手機 --}}
                        @foreach($newsList as $news)
                        <div class="middle-info hot-content">
                            <p class="time"><a href="{{ route('news.detail', ['slug' =>$news->id]) }}">{{$news->title}}</a>
                            </p>
                            <p>{{$news->excerpt}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@endsection