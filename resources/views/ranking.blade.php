@extends('layouts.app')

@section('style')
<style>
	.ranking-tabs {
		margin: 16px 0 8px;
		border-bottom: 2px solid #fdb93b;
	}

	.ranking-tabs > li > a {
		margin-right: 8px;
		padding: 10px 22px;
		border: 0;
		border-radius: 8px 8px 0 0;
		background: #fff4d6;
		color: #272959;
		font-size: 18px;
		font-weight: bold;
	}

	.ranking-tabs > li > a:hover,
	.ranking-tabs > li > a:focus {
		background: #ffe4a3;
		color: #272959;
	}

	.ranking-tabs > li.active > a,
	.ranking-tabs > li.active > a:hover,
	.ranking-tabs > li.active > a:focus {
		background: #fdb93b;
		color: #272959;
		border: 0;
	}

	.ranking-tab-pane {
		padding-top: 8px;
	}

	.ranking-empty {
		margin: 24px 8px;
		color: #414549;
		font-size: 16px;
	}
</style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="content-container">
					<div class="row">
						<div class="col-md-12">
							<div class="section-container">
								<div class="section-title mb-3">排行榜</div>

								<div class="section-content">
									@if (count($seasonRankings) > 1)
										<ul class="nav nav-tabs ranking-tabs">
											@foreach ($seasonRankings as $seasonRanking)
												<li class="{{ $loop->first ? 'active' : '' }}">
													<a href="#season-ranking-{{ $seasonRanking['id'] }}" data-toggle="tab">{{ $seasonRanking['name'] }}</a>
												</li>
											@endforeach
										</ul>
										<div class="tab-content">
											@foreach ($seasonRankings as $seasonRanking)
												<div class="tab-pane ranking-tab-pane {{ $loop->first ? 'active' : '' }}" id="season-ranking-{{ $seasonRanking['id'] }}">
													@include('ranking.boards', ['rankings' => $seasonRanking['rankings']])
												</div>
											@endforeach
										</div>
									@elseif (count($seasonRankings) === 1)
										@include('ranking.boards', ['rankings' => $seasonRankings[0]['rankings']])
									@else
										<p class="ranking-empty">暫時未有排行資料。</p>
									@endif

									<div class="row">
										<div class="col-md-12 col-sm-12 text-right">
											<span class="remark">*每小時更新一次</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
