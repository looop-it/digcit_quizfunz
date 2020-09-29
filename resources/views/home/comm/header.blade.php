@include('home.advertisement.top-banner-mobile')

@php
$page = isset($page) ? $page : 'other';	
@endphp

@if($page != 'news')
	@include('home.comm.new_first')
@endif