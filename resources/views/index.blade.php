@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/home/css/swiper-2.7.6.min.css"/>

<style type="text/css">
	.section .section-middle>div .left-content div p:not(:nth-child(1))::after {
		width: 13px;
	}

	.section .section-middle>div>div:nth-child(2) {
		padding: 0 13px 0 18px;
	}


	.section {
		padding-top: 1px;
	}

	.section .section-top {
		margin: 0;
	}

	@media (max-width: 1200px) and (min-width: 992px) {
		.section .section-middle>div .left-content div p:not(:nth-child(1))::after {
			width: 16px;
		}
	}

	@media (max-width: 992px) {
		.section .section-middle>div .left-content div p:not(:nth-child(1))::after {
			width: 23px;
		}
	}

	/*@media (min-width: 768px){
			.col-sm-push-5 {
				left: 38.666667%;
			}
			.col-sm-pull-8 {
				right: 66.666667%;
			}
		}*/

	a:link {
		text-decoration: none;
	}

	/* 	a:hover{color:red !important;}     */

	.section .section-middle>div .left-content {

		/* height: auto; */
	}

	.swal2-confirm {
		font-size: 1.5em !important;
	}

	#swal2-title {
		font-size: 2.5em !important;
	}

	#swal2-content {
		font-size: 1.5em !important;
	}
</style>
@endsection

@section('content')
@php
$nav=0
@endphp

<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="section section-idx">
				<!--手機版參加人數,要判斷是pc還是手機-->
				<div class="section-middle clearfix">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">

							@include('home.comm.new_first')
							<!--轮播-->
							@include('home.advertisement.main-slider')
							<div class="banner-bottom clearfix">
								<div>
									<div>
										<a href="{{ route('information') }}"><img
												src="/home/img/activeDetail.png" /></a>
									</div>
								</div>
								<div>
									<div>
										<a href="{{ route('references') }}"><img src="/home/img/reference.png" /></a>
									</div>

								</div>
							</div>
							<!--廣告-->
							<div class="banner-bottom clearfix">
								@include('home.advertisement.center-left-ad')
								@include('home.advertisement.center-right-ad')
							</div>
						</div>
						<div class="section-top col-md-4 col-sm-12 col-xs-12 col-md-pull-8">
							@if($global->rank_status==1)
							{{-- <div class="col-md-4 col-sm-4 col-xs-12 rank-top">
										<h4>{{trans('home.school_participation_rate_ranking.title')}}</h4>
							<ul class="clearfix sidebar-ranking">
								@if (isset($rankingData['participate_rate']) && count($rankingData['participate_rate']))
								@foreach ($rankingData['participate_rate'] as $rank)
								<li>
									<a href="">
										<div>{{ $loop->iteration }}</div>
										<div>{{ $rank->name }}</div>
										<div>{{ round($rank->rate, 2) }}%</div>
									</a>

								</li>
								@break($loop->iteration == 5)
								@endforeach
								@else
								<li>
									<a href="">
										<div></div>
										<div>{{trans('home.rank.msg')}}</div>
										<div></div>
									</a>

								</li>
								@endif
							</ul>
							<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a>
							</div>
							<div class="star">
								<img src="/home/img/star.png" />
							</div>
						</div>


						<div class="col-md-4 col-sm-4 col-xs-12 rank-top">
							<h4>{{trans('home.sum_total_ranking.title')}}</h4>
							<ul class="clearfix sidebar-ranking">
								@if (isset($rankingData['accumulate_score']) && count($rankingData['accumulate_score']))
								@foreach ($rankingData['accumulate_score'] as $rank)
								<li>
									<a href="">
										<div>{{ $loop->iteration }}</div>
										<div>{{ $rank->name }}</div>
										<div>{{ $rank->score }}分</div>
									</a>

								</li>
								@break($loop->iteration == 5)
								@endforeach
								@else
								<li>
									<a href="">
										<div></div>
										<div>{{trans('home.rank.msg')}}</div>
										<div></div>
									</a>

								</li>
								@endif
							</ul>
							<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a>
							</div>
							<div class="star">
								<img src="/home/img/star.png" />
							</div>
						</div>

						<div class="col-md-4 col-sm-4 col-xs-12 rank-top">
							<h4>{{trans('home.personal_ranking.title')}}</h4>
							<ul class="clearfix sidebar-ranking">
								@if (isset($rankingData['personal']) && count($rankingData['personal']))
								@foreach ($rankingData['personal'] as $rank)
								<li>
									<a href="">
										<div>{{ $loop->iteration }}</div>
										<div>{{ $rank->participant->name }}</div>
										<div>{{ $rank->score }}分</div>
									</a>

								</li>
								@break($loop->iteration == 5)
								@endforeach
								@else
								<li>
									<a href="">
										<div></div>
										<div>{{trans('home.rank.msg')}}</div>
										<div></div>
									</a>

								</li>
								@endif
							</ul>
							<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a>
							</div>
							<div class="star">
								<img src="/home/img/star.png" />
							</div>
						</div> --}}
						@endif

						<!--左側導讀及參考資料-->
						<div class="section-middle clearfix">
							<div class="col-md-12 col-sm-12 col-xs-12">
								@include('home.comm.referenceMaterial')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@section('javascript')
<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>

@if($global->total_number > 0)
	@include('home.comm.numRoll')
@endif

@auth
	@if(session('challengeable') === true)
		@include('home.comm.alert_challenge')
	@endif
@endauth

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
@endsection
