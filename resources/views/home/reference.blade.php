<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{trans('home.main_menu.ref_info')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">    
        
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    
    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/swiper-2.7.6.min.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/style.css"/>
    <style>
        .section .section-right .loading {

            height: 52px;
        }
		
		.section .banner{
			margin-top: 14px;
		}
        .hot-content h4{ word-wrap:break-word; width:100%;}
        .rank-imgBox p{word-wrap:break-word; width:100%;}
        .section .section-right .hot-content > div > div:nth-child(2){overflow: visible;}
    </style>
</head>
<body>
@php($nav=3)
@include('home.comm.head')
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
                    <div class="section-right reference">
                        @if(!Agent::isMobile())
                            @include('home.advertisement.top-banner-desktop')
                        @endif
                        <div class="datum datum-re">
                            <h2>{{trans('home.main_menu.ref_info')}}</h2>
                            {{-- @if(Agent::isMobile())
                                @include('home.advertisement.main-slider')
                            @endif --}}
                            @if($references)
                                @foreach($references as $value)
                                    <div class="hot-content bgColor">
                                        <h4>
                                            @if($value->link)
                                                <a href="{{$value->link}}" target="_blank">
                                            @else
                                                <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                            @endif
                                                {{$value->name}}</a></h4>
                                        <div class="rank-imgBox clearfix">
                                            <div>
                                                @if($value->link)
                                                    <a href="{{$value->link}}" target="_blank">
                                                        @else
                                                            <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                                                @endif
                                                <img src="{{$img_url.$value->cover_image}}"/></a>
                                            </div>
                                            <div>
                                                <!--<textarea>{{$value->desc}}</textarea>-->
                                                <p>{{$value->desc}}</p>
                                            </div>
                                        </div>
                                        {{--<div class="more">--}}
                                            {{--@if($value->link)--}}
                                                {{--<a href="{{$value->link}}" target="_blank">--}}
                                                    {{--@else--}}
                                                        {{--<a href="{{ route('references.detail', ['id' => $value->id]) }}">--}}
                                                            {{--@endif--}}
                                            {{--{{lang('更多')}}--}}
                                                {{--...</a></div>--}}
                                    </div>
                                @endforeach
                                <div class="loading">
                                    {{$references->links('common.pagination')}}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@include('home.comm.foot')
{{-- Common Js --}}
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
@if($global->total_number > 0)
    @include('home.comm.numRoll')
@endif
{{--<script src="/home/js/slider.js" type="text/javascript" charset="utf-8"></script>--}}
<script type="text/javascript" src="/home/js/overfloat.js"></script>
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function () {
        var mySwiper3 = new Swiper('#swiper-container3', {
            // 如果需要分页器
            pagination: '#swiper-container3 .pagination',
            paginationClickable: true,
            observer: true,
            observeParents: true,
            autoplayDisableOnInteraction: false,
            autoResize: true,
            grabCursor: true,
            loop: true,
            speed: 1500,
            autoplay: 2000,
            initialSlide: 0,
            resistanceRatio: 0,
            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            centeredSlides: true,
            coverflow: {
                rotate: 30,
                stretch: 10,
                depth: 60,
                modifier: 2,
                slideShadows: true
            },
        })
        $('.swiper-button-prev').on('click', function (e) {
            e.preventDefault()
            mySwiper3.swipePrev()
        })
        $('.swiper-button-next').on('click', function (e) {
            e.preventDefault()
            mySwiper3.swipeNext()
        })
        $("#swiper-container3").mouseenter(function(e) {
            e.preventDefault()
            mySwiper3.stopAutoplay();
        }).mouseleave(function(e) {
            e.preventDefault()
            mySwiper3.startAutoplay();
        });
    })
</script>
</body>
</html>
