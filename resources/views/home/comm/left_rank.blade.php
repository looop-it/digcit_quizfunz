	
<div class="section-top col-md-4 col-sm-12 col-xs-12 col-md-pull-8">
	
	{{-- Disable sidebar ranking --}}
	{{-- @if($global->rank_status==1)
		<div class="col-md-4 col-sm-4 col-xs-12 rank-top">
			<h4>{{trans('home.school_participation_rate_ranking.title')}}</h4>
			<ul class="clearfix sidebar-ranking">
				@if (isset($rankingData['participate_rate']) && count($rankingData['participate_rate']))
					@foreach ($rankingData['participate_rate'] as $rank)
						<li>
							<a href="">
								<div>{{ $loop->iteration }}</div>
								<div>{{ $rank->name }}</div>
								<div>{{ round($rank->rate, 2) }}%</div>
							</a>
							
						</li>
						@break($loop->iteration == 5)
					@endforeach
				@else
					<li>
						<a href="">
							<div></div>
							<div>{{trans('home.rank.msg')}}</div>
							<div></div>
						</a>
						
					</li>
				@endif
			</ul>
			<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a></div>
			<div class="star">
				<img src="/home/img/star.png"/>
			</div>
		</div>
		
		
		<div class="col-md-4 col-sm-4 col-xs-12 rank-top">
			<h4>{{trans('home.sum_total_ranking.title')}}</h4>
			<ul class="clearfix sidebar-ranking">
				@if (isset($rankingData['accumulate_score']) && count($rankingData['accumulate_score']))
					@foreach ($rankingData['accumulate_score'] as $rank)
						<li>
							<a href="">
								<div>{{ $loop->iteration }}</div>
								<div>{{ $rank->name }}</div>
								<div>{{ $rank->score }}分</div>
							</a>
							
						</li>
						@break($loop->iteration == 5)
					@endforeach
				@else
					<li>
						<a href="">
							<div></div>
							<div>{{trans('home.rank.msg')}}</div>
							<div></div>
						</a>
						
					</li>
				@endif
			</ul>
			<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a></div>
			<div class="star">
				<img src="/home/img/star.png"/>
			</div>
		</div>

		<div class="col-md-4 col-sm-4 col-xs-12 rank-top">
			<h4>{{trans('home.personal_ranking.title')}}</h4>
			<ul class="clearfix sidebar-ranking">
				@if (isset($rankingData['personal']) && count($rankingData['personal']))
					@foreach ($rankingData['personal'] as $rank)
						<li>
							<a href="">
								<div>{{ $loop->iteration }}</div>
								<div>{{ $rank->participant->name }}</div>
								<div>{{ $rank->score }}分</div>
							</a>
							
						</li>
						@break($loop->iteration == 5)
					@endforeach
				@else
					<li>
						<a href="">
							<div></div>
							<div>{{trans('home.rank.msg')}}</div>
							<div></div>
						</a>
						
					</li>
				@endif
			</ul>
			<div class="more"><a href="{{ route('ranking') }}">{{trans('home.global.more')}}...</a></div>
			<div class="star">
				<img src="/home/img/star.png"/>
			</div>
		</div> 
		
  	@endif--}}

	<!--左側最新消息-->
	@if(!Agent::isMobile())
		<div class="section-middle clearfix">
			<div class="col-md-12 col-sm-12 col-xs-12">
				@include('home.comm.latest_news')
			</div>
		</div>
	@endif

	<!--左側導讀及參考資料-->
	<div class="section-middle clearfix section-other">
		<div class="col-md-12 col-sm-12 col-xs-12">
			@include('home.comm.referenceMaterial')
		</div>
	</div>
</div>