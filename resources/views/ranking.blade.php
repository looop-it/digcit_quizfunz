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
										@foreach ($rankings as $ranking)
											@include('ranking.list', [
												'type' => $ranking['type'],
												'title' => $ranking['title'],
												'ranks' => $ranking['ranks']
											])
										@endforeach
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
