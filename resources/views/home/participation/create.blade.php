<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>參賽資料</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	
	{{-- Common CSS --}}
	<script src="{{ asset('js/manifest.js') }}"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="/home/css/bootstrap-select.min.css" />
	<link rel="stylesheet" type="text/css" href="/home/css/common.css" />
	<link rel="stylesheet" type="text/css" href="/home/css/hot.css" />
	<link rel="stylesheet" type="text/css" href="/home/css/style.css" />
	<link rel="stylesheet" type="text/css" href="/home/css/valid.css" />
	<link rel="stylesheet" type="text/css" href="/bower/select2/dist/css/select2.min.css" />

	
	<style type="text/css">
		.section .section-right .signup .agree button {
			background: url("/images/competition/start.png") no-repeat center;
			background-size: 100% 100%;
		}
	</style>
</head>

<body>
	@include('home.comm.head')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="section clearfix">
					<div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
						<div class="section-right">
							<h2>參賽資料</h2>
							<div class="signup">
								{{-- Disable mobile alert for new history quiz --}}
								{{-- @include('home.participation.no_mobile') --}}
								
								@if ($errors->any())
									<br />
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

								<form action="{{ route('participant.store') }}" method="post" class="demoform">
									{{ csrf_field() }}

									<div class="from clearfix">
										<div>
											<label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>真實姓名</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ old('name') }}" name="name" placeholder="請輸入真實姓名" datatype="*2-20" errormsg="姓名格式不正確" nullmsg="請輸入真實的姓名"/>
												<p class="Validform_checktip">請輸入真實的姓名</p>
											</div>

											<label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>學校類型</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<select name="school_type" id="school_type" datatype="*" nullmsg="請選擇學校類型">
													<option value="" selected>請選擇學校類型</option>
													<option value="secondary" >中學</option>
													<option value="university" >大學</option>
												</select>
												<p class="Validform_checktip">請選擇學校類型</p>
											</div>


											<label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>學校</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<select name="school_id" id="school_id" datatype="*" nullmsg="請選擇學校">
													<option value="" selected>請先選擇學校類型</option>
													{{-- <option value=""  style="color: #908d8d;cursor: not-allowed;">{{trans('home.student_app_form.please_choose')}}</option> --}}
													{{-- @if($schools)
														@foreach($schools as $value)
															@if(old('school_id') == $value->id)
															<option value="{{$value->id}}" selected>{{$value->name}}</option>
															@else
															<option value="{{$value->id}}">{{$value->name}}</option>
															@endif
														@endforeach
													@endif --}}
												</select>
												<p class="Validform_checktip">請選擇學校</p>
											</div>

											{{-- <label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>年級</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ old('grade') }}" name="grade" placeholder="請輸入年級" datatype="s1-18" errormsg="年級格式不正確" nullmsg="請輸入年級" />
												<p class="Validform_checktip">請輸入年級</p>
											</div>

											<label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>班別</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ old('class') }}"  name="class" placeholder="請輸入班別" datatype="s1-18" errormsg="班別格式不正確" nullmsg="請輸入班別" />
												<p class="Validform_checktip">請輸入班別</p>
											</div>
											
											<label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>學校認證碼</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" name="code" value="{{ old('code') }}" datatype="s5-30" errormsg="您輸入的學校認證碼格式不正確" nullmsg="請輸入學校認證碼" />
											</div> --}}
										</div>
									</div>

									@include('home.participation.tips')

									<div class="agree">
										<div>
											<button class="btn"></button>
										</div>
									</div>

									{{-- @include('home.participation.recaptcha') --}}
									
								</form>

								

								<p>&nbsp;</p>
								
								{{-- <div class="star">
									<img src="/home/img/star.png" />
								</div> --}}
							</div>
						</div>
						
					</div>
					
					@include('home.comm.left_rank')
					
				</div>
			</div>
		</div>
	</div>
	@include('home.comm.foot')
	
	{{-- Common Js --}}
	<script src="{{ asset('js/vendor.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>

	<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/bower/jquery/dist/jquery.min.js"></script>
	{{-- <script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script> --}}
	<script type="text/javascript" src="/bower/select2/dist/js/select2.js"></script>

	
	@if($global->total_number > 0)
	@include('home.comm.numRoll') @endif
	<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript">
	$(function(){
		// School list json filter by type
		var schools_json = {!!json_encode($schools_json)!!};

		// Init School type select
		$("#school_type").select2({"allowClear":false,"placeholder":{"id":"","text":"請選擇學校類型"}});

		// Add school type select trigger for init school list
		$("#school_type").on("select2:select", function(e) {
			var school_type = $("#school_type option:checked").val();//获取select的值
			console.log(schools_json[school_type]);
			if (school_type =='secondary' || school_type =='university') {
				// Reset and re-init school list
				$("#school_id").html("");
				$("#school_id").select2({
					data         : schools_json[school_type],
					"allowClear" : false,
					"placeholder": {"id":"","text":"\u53ef\u641c\u7d22\u7be9\u9078"}
				});
			}
			
		});
	});
	
	// $('#school_id').select2({"allowClear":true,"placeholder":{"id":"","text":"\u53ef\u641c\u7d22\u7be9\u9078"}});
	// 	$(".demoform").Validform({

    //    tiptype: function (msg, o, cssctl) {
    //         if (!o.obj.is("form")) {
    //             if(o.type != 2){
    //                 var objtip = o.obj.siblings(".Validform_checktip");
    //                 cssctl(objtip, o.type);
    //                 objtip.text(msg);
    //             }else {
    //                 o.obj.siblings(".Validform_checktip").html("");
    //             }

    //         }
    //     },

    //     datatype: {
    //         'select': /^[^no]$/,
    //         'datenoe': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/,

    //     }
    // });

	</script>

	<script type="text/javascript">
		$(".from option:nth-child(1)").prop("selected", 'selected');
	</script>
</body>

</html>