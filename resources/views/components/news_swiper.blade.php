<div class="row visible-xs">
    <div class="col-xs-12">
        <div class="mobile-latest-news">
            <div class="news-swiper-container">
                <div class="swiper-wrapper">
                    @foreach($latestNews as $news)
                    <div class="swiper-slide">
                        <a href="{{ route('news.detail', ['id' => $news->id]) }}" class="title">
                            {{ $news->title }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>