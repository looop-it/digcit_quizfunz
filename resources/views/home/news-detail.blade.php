<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>{{trans('home.news_detail.title')}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

		{{-- Common CSS --}}
		<script src="{{ asset('js/manifest.js') }}"></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
		<link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
		<style>
			.section .section-top .section-other{
				margin-top: 0 !important;
			}
			.hotnews img{width:100%!important;}
			.hotnews p{word-wrap:break-word; width:100%;}
			.hotnews h4{word-wrap:break-word; width:100%;}
		</style>
	</head>
	<body>
	@php($nav=1)
	@include('home.comm.head')
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="section clearfix">
						
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-middle section-idxmid">
							<div>
							@if(Agent::isMobile())
								@include('home.comm.header')
							@endif
							</div>
						</div>
					</div>
					
						<div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
							<div class="section-right">
								<h2>{{trans('home.news_detail.title')}}</h2>
								<div class="hotnews">
									<h4>{{$newsdetail->title}}</h4>
									<ul class="clearfix">
										<li>{{trans('home.news_detail.date')}}：<span>{{$newsdetail->published_at}}</span></li>
										<!--<li>{{trans('home.news_detail.number_of_times_read')}}：<span>{{$newsdetail->hits}}{{trans('home.news_detail.times')}}</span></li>-->
									</ul>
									<div>
										<p>{!!$newsdetail->content!!}</p>  
									</div>
								</div>
							</div>
							
						</div>
@include('home.comm.left_rank')
					</div>
				</div>
			</div>
		</div>
@include('home.comm.foot')

{{-- Common Js --}}
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/home/js/overfloat.js"></script>

	@if($global->total_number > 0)
		@include('home.comm.numRoll')
	@endif

<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
  