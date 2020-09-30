@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="content-container">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
						@if (! Agent::isMobile())
						<div class="row mb-3">
							<div class="col-xs-12">
								@include('home.comm.latest_news')
							</div>
						</div>
						@endif

                        <div class="row">
                            <div class="col-xs-12">
                                @include('home.comm.referenceMaterial')
                            </div>
                        </div>
					</div>

					<div class="col-md-8 col-sm-12">
                        <div class="section-container">
							<div class="section-title mb-3">參賽資料</div>

							@if ($errors->any())
								<br />
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $index => $error)
											@if ($index == 'g-recaptcha-response')
											<li>檢測到不正常操作，請稍後重試！如錯誤持續出現，請聯絡我們！</li>
											@else
											<li>{{ $error }}</li>
											@endif
										@endforeach
									</ul>
								</div>
							@endif

							<form class="form-horizontal" action="{{ route('participant.validate') }}" method="post">
								{{ csrf_field() }}

								<div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">真實姓名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $participant->name }}" readonly>
                                    </div>
								</div>

								<div class="form-group">
                                    <label for="school" class="col-sm-3 control-label">學校</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="school" name="school" value="{{ $participant->school->name ?? $participant->school_name }}" readonly>
                                    </div>
								</div>

								<div class="form-group">
                                    <label for="grade" class="col-sm-3 control-label">年級</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="grade" name="grade" value="{{ $participant->grade }}" readonly>
                                    </div>
								</div>

								<div class="form-group">
                                    <label for="class" class="col-sm-3 control-label">班別</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="class" name="class" value="{{ $participant->class }}" readonly>
                                    </div>
								</div>

								{{-- @include('home.participation.recaptcha') --}}

								<div class="form-group">
                                    <div class="col-sm-12 text-center">
									<button type="submit" class="btn-image">
										<img src="/home/img/start.png" class="img-fluid">
									</button>
									
                                    </div>
                                </div>
							</form>

							如需修改參賽資料請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank"><u>聯絡我們</u></a>

							@include('home.participation.tips')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
