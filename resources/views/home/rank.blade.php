<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>{{trans('home.main_menu.ranking')}}</title>
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
		<link rel="stylesheet" type="text/css" href="/home/css/ranking.css"/>

		<style>
			.remark {
				font-size: 17px;
				/* font-weight: bold; */
			}
		</style>
	</head>
	<body>
	@php($nav=5)
	@include('home.comm.head')
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="section clearfix">

						@if(Agent::isMobile())
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="section-middle section-idxmid">
								<div>
									@include('home.comm.header')
								</div>
							</div>
						</div>
						@endif

						<div class="ranking-section">
								@if($global->rank_status==1)
								<div class="col-md-12">
									<h2>{{ $season->name }} 中學排行榜</h2>
								</div>
								
								
									{{-- <div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.school_top10_blk.title')}}</h4>

											<ul class="clearfix">
												@if (isset($rankingData['school']) && count($rankingData['school']))
													@foreach ($rankingData['school'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
															<!--<div> {{ round($rank->score, 2) }}分 </div>-->
														</li>
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more"><!-- <a href="">{{trans('home.global.more')}}...</a> --></div>
											<div class="star">
												<img src="/home/img/star.png"/>
											</div>
										</div>
									</div> --}}

									{{-- 中學組排行榜 --}}

									
									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.school_participation_rate_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['participate_count']['secondary']) && count($rankingData['participate_count']['secondary']))
													@foreach ($rankingData['participate_count']['secondary'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
															<div>{{ $rank->participants }}</div>
															
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>
									
									
									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.sum_total_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['accumulate_score']['secondary']) && count($rankingData['accumulate_score']['secondary']))
													@foreach ($rankingData['accumulate_score']['secondary'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
															<div>{{ $rank->score }}分</div>
															{{-- <div>{{ $rank['seconds_used'] }}</div> --}}
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>

									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.personal_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['personal']['secondary']) && count($rankingData['personal']['secondary']))
													@foreach ($rankingData['personal']['secondary'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
															<div>{{ $rank->score }}分</div>
															
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>

									<hr>
									<div class="col-md-12">
										<h2>{{ $season->name }} 大學排行榜</h2>
									</div>

									{{-- 大學組排行榜 --}}
									
									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.school_participation_rate_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['participate_count']['university']) && count($rankingData['participate_count']['university']))
													@foreach ($rankingData['participate_count']['university'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
															<div>{{ $rank->participants }}</div>
															
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>
									
									
									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.sum_total_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['accumulate_score']['university']) && count($rankingData['accumulate_score']['university']))
													@foreach ($rankingData['accumulate_score']['university'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
															<div>{{ $rank->score }}分</div>
															{{-- <div>{{ $rank['seconds_used'] }}</div> --}}
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>

									<div class="col-md-6 col-sm-6 col-xs-12 ">
										<div class="ranking-block">
											<h4>{{trans('home.personal_ranking.title')}}</h4>
											<ul class="clearfix">
												@if (isset($rankingData['personal']['university']) && count($rankingData['personal']['university']))
													@foreach ($rankingData['personal']['university'] as $rank)
														<li>
															<div>{{ $loop->iteration }}</div>
															<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
															<div>{{ $rank->score }}分</div>
															
														</li>
														@break($loop->iteration == 20)
													@endforeach
												@else
													<li>
														<div></div>
														<div>{{trans('home.rank.msg')}}</div>
														<div></div>
														
													</li>
												@endif
											</ul>
											<div class="more">{{-- <a href="">{{trans('home.global.more')}}...</a> --}}</div>
											{{-- <div class="star">
												<img src="/home/img/star.png"/>
											</div> --}}
										</div>
										
									</div>

									<div class="col-md-12 col-sm-12 text-right">
										{{-- 更新時間： {{$rankingData['lastUpdatedAt']}} --}}
										<span class="remark">*每小時更新一次</span>
									</div>
								@endif
						</div>
								
						{{-- <div class="section-right  col-md-12 col-sm-12 col-xs-12">
							<h2>{{trans('home.main_menu.ranking')}}</h2>
							<p style="font-size: 28px; margin: 20px;text-align: center;">{{trans('home.rank.msg')}}</p>
						</div> --}}
{{-- @include('home.comm.left_rank') --}}
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
		<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
