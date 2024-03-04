<!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
		<div class="swiper-slide">
			<a href="#">
				<img src="/images/slider1.jpg" class="img-fluid" />
			</a>
		</div>
		@if(isset($advertisements['main-slider']))
			@foreach($advertisements['main-slider'] as $value)
				<div class="swiper-slide">
					<a href="{{$value->url}}" @if($value->target==1)target="_blank"@endif>
						<img src="{{$img_url.$value->image_path}}" class="img-fluid" />
					</a>
				</div>
			@endforeach
		@endif
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>