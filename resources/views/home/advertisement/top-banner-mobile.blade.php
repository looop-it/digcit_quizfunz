{{-- 手機版廣告,要判斷是pc還是手機 --}}
@if(isset($advertisements['top-banner']))
@php($advertisement = $advertisements['top-banner'])
<div class="topAd">
	<a href="{{$advertisement->url}}" @if($advertisement->target==1)target="_blank"@endif ><img src="{{$img_url.$advertisement->image_path}}" alt="{{$advertisement->remark}}" class="imgAuto"/></a>
</div>
@endif
{{-- 手機版廣告,要判斷是pc還是手機 --}}
