@if($showNews && $latestNews)
    <div class="left-content">
        <h6>最新消息</h6>
        <div>
            @foreach($latestNews as $news)
                <a href="{{ route('news.detail', ['id' => $news->id]) }}">
                    <p class="time">{{$news->title}}</p>
                </a>
                <p>{{$news->excerpt}}</p>
            @endforeach
        </div>

        <div class="more">
            <a href="{{ route('news') }}">更多...</a>
        </div>
    </div>
@endif
