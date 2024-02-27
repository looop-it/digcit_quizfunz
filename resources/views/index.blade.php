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
		Swal.fire({
		type: 'info',
		width: 600,
		title: '各位同學︰龍年的開展也是下學期的開始，為讓各位同學更好地準備比賽，「家國公民智多Fun」全港中學生知識競賽線上校際團體賽順延至3月4日至29日進行！祝大家龍馬精神、學業進步、心想事成！',
		html: '',
		showConfirmButton: true,
		showCloseButton: true,
		});
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