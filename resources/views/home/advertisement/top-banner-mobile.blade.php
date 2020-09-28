
@if(isset($advertisements['top-banner']))

@php
$advertisement = $advertisements['top-banner']
@endphp

<div class="topAd">
	<a href="{{$advertisement->url}}" @if($advertisement->target==1)target="_blank"@endif ><img src="{{$img_url.$advertisement->image_path}}" alt="{{$advertisement->remark}}" class="imgAuto"/></a>
</div>
@endif
