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
					<div class="col-md-12 col-sm-12 col-xs-12">
					    <div class="section-middle section-idxmid">
					    </div>
					</div>
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
								<form action="{{ route('participant.validate') }}" method="post" class="demoform">
									{{ csrf_field() }}

									<div class="from clearfix">
										<div>
											<label class="col-md-4 col-sm-4 col-xs-12">真實姓名</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ $participant->name }}" name="name" readonly/>
												<p class="Validform_checktip">&nbsp;</p>
											</div>

											<label class="col-md-4 col-sm-4 col-xs-12">學校</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ $participant->school->name ?? $participant->school_name }}" name="name" readonly/>

												<p class="Validform_checktip">&nbsp;</p>
											</div>

											{{-- <label class="col-md-4 col-sm-4 col-xs-12">年級</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ $participant->grade }}" name="grade" readonly />
												<p class="Validform_checktip">&nbsp;</p>
											</div>

											<label class="col-md-4 col-sm-4 col-xs-12">班別</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" value="{{ $participant->class }}" name="class" readonly />
												<p class="Validform_checktip">&nbsp;</p>
											</div> --}}
											
											{{-- <label class="col-md-4 col-sm-4 col-xs-12"><span class="span">*</span>學校認證碼</label> --}}
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="hidden" name="school_id" value="{{ $participant->school_id }}">
												{{-- <input type="text" name="code" datatype="s5-30" errormsg="您輸入的學校認證碼格式不正確" nullmsg="請輸入學校認證碼" /> --}}
											</div>
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

								如需修改參賽資料請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank"><u>聯絡主辦單位</u></a>

								<p>&nbsp;</p>

								<div class="star">
									<img src="/home/img/star.png" />
								</div>
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
	<script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script>
	@if($global->total_number > 0)
	@include('home.comm.numRoll') @endif
	<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript">
		$(".demoform").Validform({

       tiptype: function (msg, o, cssctl) {
            if (!o.obj.is("form")) {
                if(o.type != 2){
                    var objtip = o.obj.siblings(".Validform_checktip");
                    cssctl(objtip, o.type);
                    objtip.text(msg);
                }else {
                    o.obj.siblings(".Validform_checktip").html("");
                }

            }
        },

        datatype: {
            'select': /^[^no]$/,
            'datenoe': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/,

        }
    });

	</script>

	<script type="text/javascript">
		$(".from option:nth-child(1)").prop("selected", 'selected');
	</script>
</body>

</html>