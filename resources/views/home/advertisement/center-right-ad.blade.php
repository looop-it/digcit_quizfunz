{{-- 手機版廣告,要判斷是pc還是手機 --}}
@if(isset($advertisements['center-right-ad']))
	@php($advertisement = $advertisements['center-right-ad'])
	<div class="ad">
		<div class="img-box">
			<a href="{{$advertisement->url}}" @if($advertisement->target==1)target="_blank"@endif ><img
						src="{{$img_url.$advertisement->image_path}}"
						alt="{{$advertisement->remark}}" class="imgAuto"/></a>
		</div>
	</div>
@endif