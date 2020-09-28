@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/home/css/swiper-2.7.6.min.css" />

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
			<div class="section">
				<!--手機版參加人數,要判斷是pc還是手機-->
				<div class="section-middle clearfix">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
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
							<div class="section-middle clearfix">
								<div class="col-md-12">
									@include('home.comm.latest_news')
								</div>
							</div>

							<p></p>
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
@auth
@if(session('challengeable') === true)
@include('home.comm.alert_challenge')
@endif
@endauth

<script type="text/javascript">
	$(document).ready(function () {
		var adsSwiper = new Swiper.default('.swiper-container', {
			direction: 'horizontal',
			loop: true,
			pagination: {
				el: '.swiper-pagination',
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	});
	
</script>
@endsection