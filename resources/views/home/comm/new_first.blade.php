@if($latestNews)
<div class="left-content left-ct">
    <h6>{{trans('home.latest_news_blk.title')}}</h6>
    <div class="slider-news">
        <div class="swiper-container" id="swiper-container2">
            <div class="swiper-wrapper">
                @foreach($latestNews as $key=> $value)
                <div class="swiper-slide">
                    <a href="{{ route('news.detail', ['id' => $value->id]) }}"><p class="time">{{$value->title}}</p></a>
                    <p>{{$value->excerpt}}</p>
                    <div class="more"><a href=""></a></div>
                </div>
                @endforeach
            </div>
            <div class="pagination"></div>
        </div>
    </div>
    <div class="star">
        <img src="/home/img/star.png"/>
    </div>
</div>
@endif