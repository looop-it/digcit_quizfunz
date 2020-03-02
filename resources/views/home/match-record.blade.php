<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{trans('home.login.title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/valid.css"/>
    <script type="text/javascript"
            src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script>
    <style type="text/css">
    	table{
    		width: 100%;
    		border-color: #00559B;
    		color: #231f20;
    	}
    	.table{
    		margin-bottom: 0;
    	}
    	th,td{
    		text-align: center;
    		padding: 3px 0;
    	}
    	.section .section-right .signup .from{
    		margin-bottom: 20px;
    		margin-top: 30px;
    		width: 96%;
    	}
    </style>
</head>
<body>
@php($nav=4)
@include('home.comm.head')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="section clearfix">
                
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="section-middle section-idxmid">
						<div>
						@if(Agent::isMobile())
							@include('home.comm.header')
						@endif
						</div>
					</div>
				</div>
				
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
                    <div class="section-right">
                        <h2>比賽記錄</h2>
                        <div class="signup">
                            <form action="" method="post" onsubmit="return checkLength()" class="demoform">
                                <div class="from clearfix">
                                    @foreach($records as $season => $papers)
                                    <h3 style="text-align:left !important">{{ $season }}</h3>
                                    <table class="table table-responsive table-striped table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>參考編號</th>
                                                <th>比賽時間</th>
                                                <th>比賽得分</th>
                                                <th>比賽使用時間 (秒)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($papers as $paper)
                                            <tr>
                                                <td>{{$paper->number}}</td>
                                                <td>{{$paper->started_at}}</td>
                                                <td>{{$paper->score}}</td>
                                                <td>{{$paper->seconds_used}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    @if (!$loop->last)
                                        <hr />
                                    @endif
                                    
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@include('home.comm.dialog')
@include('home.comm.foot')

<script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
<script type="text/javascript" src="/home/js/bootstrap.js"></script>
<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
@if($global->total_number > 0)
    @include('home.comm.numRoll')
@endif
<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
