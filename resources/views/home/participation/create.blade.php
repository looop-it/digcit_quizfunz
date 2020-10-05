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

							<form class="form-horizontal" action="{{ route('participant.store') }}" method="post">
								{{ csrf_field() }}

								<div class="form-group @if($errors->has('name')) has-error @endif">
                                    <label for="name" class="col-sm-3 control-label" required>真實姓名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入真實姓名"
                                            value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
								</div>

								<div class="form-group @if($errors->has('school_id')) has-error @endif">
                                    <label for="name" class="col-sm-3 control-label" required>學校</label>
                                    <div class="col-sm-9">
										<select name="school_id" id="school_id" class="form-control">
										</select>
										<span class="help-block">
                                            如未能在列表中找到你的學校，請<a href="{{ route('enquiry') }}">{{trans('home.footer.contact_us')}}</a>
										</span>
										
                                        @if ($errors->has('school_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('school_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
								</div>

								<div class="form-group @if($errors->has('grade')) has-error @endif">
                                    <label for="grade" class="col-sm-3 control-label" required>年級</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="grade" name="grade" placeholder="請輸入年級"
                                            value="{{ old('grade') }}" required>

                                        @if ($errors->has('grade'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('grade') }}</strong>
                                        </span>
                                        @endif
                                    </div>
								</div>

								<div class="form-group @if($errors->has('class')) has-error @endif">
                                    <label for="class" class="col-sm-3 control-label" required>班別</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="class" name="class" placeholder="請輸入班別"
                                            value="{{ old('class') }}" required>

                                        @if ($errors->has('class'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                        @endif
                                    </div>
								</div>

								<div class="form-group">
                                    <div class="col-sm-12 text-center">
									<button type="submit" class="btn-image">
										<img src="/home/img/start.png" class="img-fluid">
									</button>
									
                                    </div>
                                </div>
							</form>
							@include('home.participation.tips')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
	
@section('javascript')
<script type="text/javascript">
$(function(){
	$(document).ready(function() {
		$('#school_id').select2({
			theme: "bootstrap",
			data: {!!json_encode($schools)!!},
			allowClear:true,
			placeholder: {
				id:  "",
				text: "\u53ef\u641c\u7d22\u7be9\u9078"
			}
		});

		@if (old('school_id'))
			$('#school_id').val({{ old('school_id') }}).trigger('change');
		@endif
	});
});
</script>
@endsection
	