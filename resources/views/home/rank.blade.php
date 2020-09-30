@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/home/css/ranking.css"/>

<style>
	.remark {
		font-size: 17px;
		/* font-weight: bold; */
	}
</style>
@endsection

@section('content')
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
						@if($global->rank_status==1 || $preview == true)
						
						<div class="col-md-12">
							<h2>{{ $season->name }} 中學排行榜</h2>
						</div>
						
						
						@if ($current_week != false)
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[$current_week]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[$current_week]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['secondary'][($current_week)]) && count($rankingData['personal_weekly']['secondary'][($current_week)]))
											@foreach ($rankingData['personal_weekly']['secondary'][($current_week)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[($current_week-1)]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[($current_week-1)]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['secondary'][($current_week-1)]) && count($rankingData['personal_weekly']['secondary'][($current_week-1)]))
											@foreach ($rankingData['personal_weekly']['secondary'][($current_week-1)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							@if($current_week == 13)
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[($current_week-2)]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[($current_week-2)]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['secondary'][($current_week-2)]) && count($rankingData['personal_weekly']['secondary'][($current_week-2)]))
											@foreach ($rankingData['personal_weekly']['secondary'][($current_week-2)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							@endif
						@endif
							
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>{{trans('home.school_participation_rate_ranking.title')}}</h4>
									<ul class="clearfix">
										@if (isset($rankingData['participate_count']['secondary']) && count($rankingData['participate_count']['secondary']))
											@foreach ($rankingData['participate_count']['secondary'] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
													{{-- <div>{{ $rank->participants }}</div> --}}
													
												</li>
												@break($loop->iteration == 10)
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
													{{-- <div>{{ $rank->score }}分</div> --}}
													{{-- <div>{{ $rank['seconds_used'] }}</div> --}}
												</li>
												@break($loop->iteration == 10)
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

							

							{{-- <div class="col-md-6 col-sm-6 col-xs-12 ">
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
												@break($loop->iteration == 10)
											@endforeach
										@else
											<li>
												<div></div>
												<div>{{trans('home.rank.msg')}}</div>
												<div></div>
												
											</li>
										@endif
									</ul>
									<div class="more"></div>
								</div>
							</div> --}}
						</div>
						<div class="ranking-section">

							<hr>
							<div class="col-md-12">
								<h2>{{ $season->name }} 大學排行榜</h2>
							</div>

							{{-- 大學組排行榜 --}}

							@if ($current_week != false)
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[$current_week]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[$current_week]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['university'][($current_week)]) && count($rankingData['personal_weekly']['university'][($current_week)]))
											@foreach ($rankingData['personal_weekly']['university'][($current_week)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[($current_week-1)]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[($current_week-1)]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['university'][($current_week-1)]) && count($rankingData['personal_weekly']['university'][($current_week-1)]))
											@foreach ($rankingData['personal_weekly']['university'][($current_week-1)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							@if($current_week == 13)
							<div class="col-md-6 col-sm-6 col-xs-12 ">
								<div class="ranking-block">
									<h4>每周最強知識王（{{date_format(date_create($weekly_ranking_range[($current_week-2)]['start_date']), 'm/d')}} - {{date_format(date_create($weekly_ranking_range[($current_week-2)]['end_date']), 'm/d')}}）</h4>
									<ul class="clearfix">
										@if (isset($rankingData['personal_weekly']['university'][($current_week-2)]) && count($rankingData['personal_weekly']['university'][($current_week-2)]))
											@foreach ($rankingData['personal_weekly']['university'][($current_week-2)] as $rank)
												<li>
													<div>{{ $loop->iteration }}</div>
													<div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
													<div>{{ $rank->score }}分</div>
													
												</li>
												@break($loop->iteration == 10)
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
									
								</div>
								
							</div>
							@endif
						@endif
							
							{{-- <div class="col-md-6 col-sm-6 col-xs-12 ">
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
												@break($loop->iteration == 10)
											@endforeach
										@else
											<li>
												<div></div>
												<div>{{trans('home.rank.msg')}}</div>
												<div></div>
												
											</li>
										@endif
									</ul>
									<div class="more"></div>
							
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
												</li>
												@break($loop->iteration == 10)
											@endforeach
										@else
											<li>
												<div></div>
												<div>{{trans('home.rank.msg')}}</div>
												<div></div>
												
											</li>
										@endif
									</ul>
									<div class="more"></div>
								</div>
							</div> --}}

							{{-- <div class="col-md-6 col-sm-6 col-xs-12 ">
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
												@break($loop->iteration == 10)
											@endforeach
										@else
											<li>
												<div></div>
												<div>{{trans('home.rank.msg')}}</div>
												<div></div>
												
											</li>
										@endif
									</ul>
									<div class="more"></div>
									
								</div>
								
							</div> --}}

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
@endsection