@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
					@include('left_panel')
					
					<div class="col-md-8 col-sm-12">
						<div class="row mb-3">
							<div class="col-sm-12">
								@include('home.advertisement.main-slider')
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 col-xs-6 text-center">
								<a href="{{ route('information') }}"><img src="/home/img/activeDetail.png" class="img-fluid" /></a>
							</div>
							<div class="col-md-6 col-xs-6 text-center">
								<a href="{{ route('references') }}"><img src="/home/img/reference.png" class="img-fluid" /></a>
							</div>
						</div>

						@if (Agent::isMobile())
						<div class="row">
							<div class="col-xs-12">
								@include('home.comm.referenceMaterial')
							</div>
						</div>
						@endif
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