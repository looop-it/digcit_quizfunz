@extends('layouts.app')

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
									<div class="row ranking-section">
										@php
										 $title = date_format(date_create($weekly_ranking_range[$current_week]['start_date']), 'm/d') . "-" . date_format(date_create($weekly_ranking_range[$current_week]['end_date']), 'm/d');
										@endphp

										@include('ranking.list', [
											'title' => "每周最強知識王（{$title}）",
											'ranks' => $rankingData['personal_weekly']['secondary'][($current_week)]
										])

										@php
										$title = date_format(date_create($weekly_ranking_range[$current_week - 1]['start_date']), 'm/d') . "-" . date_format(date_create($weekly_ranking_range[$current_week - 1]['end_date']), 'm/d');
										@endphp

										@include('ranking.list', [
											'title' => "每周最強知識王（{$title}）",
											'ranks' => $rankingData['personal_weekly']['secondary'][($current_week - 1)]
										])

										@include('ranking.list', [
											'title' => "最具人氣學校",
											'ranks' => $rankingData['participate_count']['secondary']
										])

										@include('ranking.list', [
											'title' => "最傑出學校表現",
											'ranks' => $rankingData['accumulate_score']['secondary']
										])
									</div>

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
