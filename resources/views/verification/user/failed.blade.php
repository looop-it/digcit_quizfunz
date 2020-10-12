@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
				<div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12">
						<div class="message-container bg-white">
                            <div class="message-header text-center">
                                啟動帳號失敗
							</div>

							<div class="message-content">
                                抱歉，您的帳號未能啟動。如有問題，請<a href="{{ route('enquiry') }}">聯絡我們</a>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
