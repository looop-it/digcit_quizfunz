@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container news-list">
                <div class="row">
                    {{-- @include('left_panel', ['showNews' => false]) --}}

                    <div class="col-md-12 col-sm-12">
                        <div class="section-container">
                            <div class="section-title mb-3">最新消息</div>

                            <div class="section-content">
                                @foreach($newsList as $news)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <a href="{{ route('news.detail', ['slug' =>$news->id]) }}" class="title">
                                                    <strong>{{ $news->title }}</strong>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if (! Agent::isMobile())
                                            <div class="col-md-3">
                                                @if($news->cover_image)
                                                <a href="{{ route('news.detail', ['slug' =>$news->id]) }}">
                                                    <img src="{{$img_url.$news->cover_image}}" class="img-fluid" />
                                                </a>
                                                @else
                                                    <img src="/images/default_cover_image.png" class="img-fluid">
                                                @endif
                                            </div>
                                            @endif
                                            <div class="col-md-8 col-xs-12">
                                                <div class="news-content">
                                                    <div class="excerpt mb-3">
                                                        <p>{{$news->excerpt}}</p>
                                                    </div>
            
                                                    <div class="more">
                                                        <a href="{{ route('news.detail', ['slug' =>$news->id]) }}">更多...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if (!$loop->last)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="loading">
                            {{ $newsList->links('common.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection