@if($references)
<div class="section-container">
    <div class="section-title mb-3">導讀及參考資料</div>

    <div class="section-content">
        @foreach($references as $reference)
            <div class="row">
                <div class="col-xs-4">
                    @if($reference->link)
                        <a href="{{$reference->link}}" target="_blank">
                            <img src="{{$img_url.$reference->cover_image}}" class="img-fluid square-image" />
                        </a>
                    @else
                        <a href="{{ route('references.detail', ['id' => $reference->id]) }}">
                            <img src="{{$img_url.$reference->cover_image}}" class="img-fluid square-image" />
                        </a>
                    @endif
                </div>

                <div class="col-xs-8">
                    @if($reference->link)
                    <a href="{{$reference->link}}" target="_blank"><p class="time">{{$reference->name}}</p></a>
                    @else
                    <a href="{{ route('references.detail', ['id' => $reference->id]) }}"><p class="time">{{$reference->name}}</p></a>
                    @endif
                </div>
            </div>

            @if(!$loop->last)
                <hr>
            @endif
        @endforeach
    </div>
</div>
@endif