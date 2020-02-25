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
    <script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script>
</head>
<body>
@php($nav=6)
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
                        <h2>個人資料</h2>
                        <div class="signup">
                            <form action="" method="post" onsubmit="return checkLength()" class="demoform">
                                <div class="from clearfix">
                                    <div style="width: 100%;">
                                        <label class="col-md-12 col-sm-12 col-xs-12">暱稱:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{$user->name}}" name="name" disabled="disabled"/>
                                            <p></p>
                                        </div>

                                        <label class="col-md-12 col-sm-12 col-xs-12">通訊電郵:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="email" value="{{$user->email}}" disabled="disabled" style="overflow: hidden;"/>
                                            <p></p>
                                        </div>

                                        <label class="col-md-12 col-sm-12 col-xs-12">聯絡電話:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{$user->mobile}}" disabled="disabled" />
                                            <p></p>
                                        </div>

                                        <label class="col-md-12 col-sm-12 col-xs-12">性別:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{$user->gender == 'm' ? '男' : '女'}}" name="repassword" disabled="disabled" />
                                            <p></p>
                                        </div>
                                        <label class="col-md-12 col-sm-12 col-xs-12">出生年月:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{ $user->birthday }}" name="repassword" disabled="disabled" />
                                            <p></p>
                                        </div>
                                        <label class="col-md-12 col-sm-12 col-xs-12" style="color: #333;margin-bottom: 10px;">
                                            <span style="color: red;">*</span>如有任何查詢／更改資料，請<a  style="font-size: 20px;color:red;" href="{{ route('page.detail', ['slug' =>'聯絡我們'])}}" target="_blank">聯絡我們</a>，謝謝！
                                        </label>
                                    </div>
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
