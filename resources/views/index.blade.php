@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
					@include('left_panel')
					
					<div class="col-md-8 col-sm-12">
						@include('components.news_swiper')

						<div class="row mb-3">
							<div class="col-md-12">
								@include('components.swiper')
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 col-xs-6 text-center" style="padding-right: 9px !important;">
								<a href="{{ route('information') }}">
									<img src="/images/information.png" class="img-fluid" />
								</a>
							</div>
							<div class="col-md-6 col-xs-6 text-center" style="padding-left: 9px !important;">
								<a href="{{ route('references') }}">
									<img src="/images/reference.png" class="img-fluid" />
								</a>
							</div>
						</div>

						{{-- <div class="row mt-3 visible-xs">
							<div class="col-xs-12">
								@include('home.comm.referenceMaterial')
							</div>
						</div> --}}
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
		// Swal.fire({
		// 	type: 'info',
		// 	width: 600,
		// 	title: '為讓更多同學認識國家安全，享受寓學習於線上問答有獎遊戲，第二屆「國家安全教育通通識」線上校際個人賽將延長至2月17日。',
		// 	html: '',
		// 	showConfirmButton: true,
		// 	showCloseButton: true,
		// });
		var adsSwiper = new Swiper.default('.swiper-container', {
			autoHeight: true,
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

		var newsSwiper = new Swiper.default('.news-swiper-container', {
			direction: 'vertical',
		});
	});
</script>
@endsection