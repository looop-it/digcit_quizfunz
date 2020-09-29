@if($latestNews)
<div class="section-container">
        <div class="section-title mb-3">最新消息</div>

        <div class="section-content">
            @foreach($latestNews as $news)
            <div>
                <p>
                    <a href="{{ route('news.detail', ['id' => $news->id]) }}" class="title">
                        {{ $news->title }}
                    </a>
                </p>
                <p>{{ str_limit($news->excerpt, 100) }}</p>

                @if(!$loop->last)
                    <hr>
                @endif
            </div>
            @endforeach
        </div>

        <div class="section-footer text-right">
            <a href="{{ route('news') }}">更多...</a>
        </div>

</div>
@endif
