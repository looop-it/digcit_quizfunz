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
									<img src="/images/information.jpg" class="img-fluid" />
								</a>
							</div>
							<div class="col-md-6 col-xs-6 text-center" style="padding-left: 9px !important;">
								<a href="{{ route('references') }}">
									<img src="/images/reference.jpg" class="img-fluid" />
								</a>
							</div>
						</div>

						<div class="row mt-3 visible-xs">
							<div class="col-xs-12">
								@include('home.comm.referenceMaterial')
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