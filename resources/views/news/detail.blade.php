@extends('layouts.app')
		
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
					<div class="col-md-12">
						<div class="section-container">
							<div class="section-title mb-3">{{ $news->title }}</div>

							<div class="section-content ck-content">
								<div class="news-detail">
									<div class="date">{{ $news->published_at }}</div>
									
									<p>{!!$news->content!!}</p>  
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col-md-12 text-center">
						<a href="{{ route('references') }}" class="btn btn-main">返回列表</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
