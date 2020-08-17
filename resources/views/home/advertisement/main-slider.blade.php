<div class="banner">
	<div class="swiper-container swiper-container-horizontal swiper-container-wp8-horizontal"
		 id="swiper-container3">
		<div class="swiper-wrapper">
			@if(isset($advertisements['main-slider']))
				@foreach($advertisements['main-slider'] as $value)
					<div class="swiper-slide">
						<div class="img-box">
							<a href="{{$value->url}}"
							   @if($value->target==1)target="_blank"@endif ><img
										src="{{$img_url.$value->image_path}}"
										class="imgAuto"/></a>
						</div>
						{{-- <div>
							<h4 style="text-align: center;">{{$value->title}}</h4>
						</div> --}}
					</div>
				@endforeach
			@endif
		</div>
		{{-- 如果需要分页器 --}}
		<div class="pagination"></div>

		{{-- 如果需要导航按钮 --}}
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</div>