@php
    $nav = isset($nav)?$nav:''
@endphp
@if($latestNews && $nav<>1)
    <div class="left-content">
        <h6>{{trans('home.latest_news_blk.title')}}</h6>
        <div>
            @foreach($latestNews as $key=> $value)
                <a href="{{ route('news.detail', ['id' => $value->id]) }}"><p class="time">{{$value->title}}</p></a>
                <p>{{$value->excerpt}}</p>
            @endforeach
        </div>
        <div class="more"><a href="{{ route('news') }}">{{trans('home.global.more')}}...</a></div>
        <div class="star">
            <img src="/home/img/star.png"/>
        </div>
    </div>
@endif
