@extends('layouts.app')
		
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
					<div class="col-md-12">
						<div class="section-container">
							<div class="section-title mb-3">最新消息詳情</div>

							<div class="section-content">
								<div class="news-detail">
									<div class="title">
										<div>{{ $news->title }}</div>
										<div>日期：{{ $news->published_at }}</div>
									</div>
								</div>

								<p>{!!$news->content!!}</p>  
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
