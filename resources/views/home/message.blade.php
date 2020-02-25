<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>挑戰成功</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
		<link rel="stylesheet" type="text/css" href="/home/css/bootstrap.css" />
		<link href="/home/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
		@if ($obj->seconds_used == 0 )
		<meta http-equiv="Refresh" content="3" />
		@endif
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 challengre-sus">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9 col-md-offset-1 col-sm-offset-1">
							<h2>大灣區學屆知識競賽</h2>
							<noscript>
							  <p>參與本競賽需要瀏覽器支持（啟用）JavaScript</p>
							</noscript>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1">
							<div class="challengre-sus-cont">
								<h1>{{$message}}</h1>
								<div class="star">
									<img src="/home/img/starbig.png"/>
								</div>
								<div class="row challengre-min clearfix">
									@if($obj)
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>總得分</p>
										<div class="num">
											<p class="bg">88888</p>
											<p>{{$obj->score}}</p>
										</div>
									</div>
									<div class="col-md-5 col-sm-6 col-xs-5 col-md-offset-1">
										<p>时间</p>
										<div class="num">
											<p class="sec"><span class="bg bg2">888</span><span class="sec-child">{{$obj->seconds_used}}</span><span class="small">秒</span></p>
										</div>
									</div>
									@endif
									<div class="col-md-12 col-sm-12 col-xs-12">
										<a href="{{url('/')}}"><p class="back">返回主頁</p></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
		<script type="text/javascript" src="/home/js/bootstrap.js"></script>
		@if($global->total_number > 0)
			@include('home.comm.numRoll')
		@endif

		<script type="text/javascript">
			
			$(function(){
				//防止页面后退
				history.pushState(null, null, document.URL);
				window.addEventListener('popstate', function () {

				history.pushState(null, null, document.URL);

				});
			});

		</script>
	</body>
</html>
