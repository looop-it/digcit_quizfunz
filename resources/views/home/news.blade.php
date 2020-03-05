<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{trans('home.main_menu.latest_news')}}</title>
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
		.section .section-top .section-other{
			margin-top: 0 !important;
		}
		/*.section .banner{
			margin-top: 14px;
		}*/
		@media (max-width: 767px){
			.section .section-right h2, .section .section-right h2 a {
				display: none;
			}
		}

        .clearfix p{word-wrap:break-word; width:100%;}
        .hot-content h4{word-wrap:break-word; width:100%;}
        .section .section-right .hot-content > div > div:nth-child(2){

            overflow: visible;
        }

        /*  			.section-right .more a:hover{color:red !important;}
                    .section-middle .left-content{height: auto !important;} */
    </style>
</head>
<body>
@php($nav=1)
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
                    <div class="section-right">
                        <h2>{{trans('home.latest_news_blk.title')}}</h2>
                        {{-- 手機版最新消息輪播,要判斷是pc還是手機 --}}
                        {{-- @if(Agent::isMobile())
                            @include('home.advertisement.main-slider')
                        @endif --}}
                        @foreach($ArticeList as $v)
                            <div class="hot-content disnone">
                                <h4><a href="{{ route('news.detail', ['slug' =>$v->id]) }}">{{$v->title}}</a></h4>
                                <div class="clearfix">
                                    <div class="bgColor">
                                        <a href="{{ route('news.detail', ['slug' =>$v->id]) }}"><img
                                                    src="{{$img_url.$v->cover_image}}"/></a>
                                    </div>
                                    <div>
                                        <p>{{$v->excerpt}}</p>
                                    </div>
                                </div>
                                <div class="more"><a href="{{ route('news.detail', ['slug' =>$v->id]) }}">{{trans('home.global.more')}}...</a></div>
                                {{-- <div class="star">
                                    <img src="/home/img/star.png"/>
                                </div> --}}
                            </div>
                        @endforeach
                        <div class="loading">

                            {{$ArticeList->links('common.pagination')}}
                        </div>
                        {{-- 手機版信息,要判斷是pc還是手機 --}}
                        @foreach($ArticeList as $v)
                            <div class="middle-info hot-content">
                                <p class="time"><a href="{{ route('news.detail', ['slug' =>$v->id]) }}">{{$v->title}}</a>
                                </p>
                                <p>{{$v->excerpt}}</p>
                                {{--<div class="more"><a href="">更多...</a></div>--}}
                            </div>
                        @endforeach
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
<script type="text/javascript" src="/home/js/overfloat.js"></script>
{{--<script src="/home/js/slider.js" type="text/javascript" charset="utf-8"></script>--}}
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
