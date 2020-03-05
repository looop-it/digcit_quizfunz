@php
    $nav = isset($nav)?$nav:''
@endphp
@if($references && $nav<>3)
    <div class="left-content">
        <h6>{{trans('home.ref_info_blk.title')}}</h6>
        @foreach($references as $value)
            <div>
                <div class="clearfix">
                    <div class="leftimg img-box">
                        @if($value->link)
                            <a href="{{$value->link}}" target="_blank">
                                @else
                                    <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                        @endif
                        <img src="{{$img_url.$value->cover_image}}"/></a>
                    </div>
                    <div>
                        <div>
                            @if($value->link)
                                <a href="{{$value->link}}" target="_blank">
                                    @else
                                        <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                            @endif
                                <p class="time">{{$value->name}}</p></a></div>
                        {{--<p>{{$value->desc}}</p>--}}
                        <div class="more"><a href="javascript:;">{{$value->created_at}}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="more"><a href="{{ route('references') }}">{{trans('home.global.more')}}...</a></div>
        {{-- <div class="star">
            <img src="/home/img/star.png"/>
        </div> --}}
    </div>
@endif