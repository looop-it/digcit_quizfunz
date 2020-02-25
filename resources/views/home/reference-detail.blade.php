<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>{{trans('home.reference_detail.title')}}</title>
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
            #fef{display: block;
            	  table-layout:fixed; word-break:break-all; overflow:hidden;  
             	  word-break:break-all; 
             	    word-wrap:break-word;  
            }
             
		</style>
	</head>
	<body>
	@php($nav=3)
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
								<h2>{{trans('home.reference_detail.title')}}</h2>
								@if($reference)
								<div class="hotnews">
									<h4>{{$reference->name}}</h4>
									<ul class="clearfix">
										<li>{{trans('home.reference_detail.date')}}：<span>{{$reference->updated_at}}</span></li>
										{{--<li>{{trans('home.reference_detail.author')}}：<span>{{$reference->author}}</span></li>--}}
										{{--<li>{{trans('home.reference_detail.number_of_times_read')}}：<span>{{$reference->hits}}{{trans('home.reference_detail.times')}}</span></li>--}}
										{{--@if($reference->link)<li>{{trans('home.reference_detail.link')}}：<span><a href="{{$reference->link}}">{{$reference->link}}</a></span></li>@endif--}}
									</ul>
									{{--<div>--}}
										{{--<img src="{{$img_url.$reference->cover_image}}"/>--}}
									{{--</div>--}}
									<div class="resDetail">
										<span id="fef">{!!$reference->content!!}</span>
									</div>
								</div>
								@endif
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
	@if($global->total_number > 0)
		@include('home.comm.numRoll')
	@endif
		<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>
		<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>  
