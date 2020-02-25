<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{session('title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    
    <link rel="stylesheet" type="text/css" href="/home/css/iconfont.css" />
    <link href="/home/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/style.css"/>
    <style>

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
@include('home.comm.head')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="section clearfix">
                <div class="section-right  col-md-8 col-sm-8 col-xs-8 col-md-push-5 col-sm-push-5">
                    <h2>{{session('title')}}</h2>
                    <div class="signup">
                        <h1>{{session('msg')}} </h1>
                    </div>
                    @if(session('status')==0)
                        <h2>{{trans('home.msg.will_be')}}<span
                                    id="mes">3</span> {{trans('home.msg.return_to_previous_page')}}！</h2>
                    @else
                        <h2>{{trans('home.msg.will_be')}}<span id="mes">3</span>{{trans('home.msg.jump')}}！</h2>
                    @endif
                    <div class="row success-btn">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <button class="btn btn-danger">{{trans('home.msg.back_to_home')}}</button>
                        </div>
                        @if(session('title')<>'退出成功' && session('title')<>'登入失敗')
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button class="btn btn-success">{{trans('home.msg.race_immediately')}}</button>
                            </div>
                        @endif
                    </div>
                </div>

                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>

@include('home.comm.foot')

		<script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
		<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="/home/js/bootstrap.js"></script>
        
        @if($global->total_number > 0)
            @include('home.comm.numRoll')
        @endif
        
		<script type="text/javascript" src="/home/js/overfloat.js"></script>
		<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
	</body>
</body>

<script>
    $('.btn-danger').click(function () {

        window.location.href = '/';

    });
    $('.btn-success').click(function () {

        window.location.href = '{{ route("competition.start") }}';
    });
</script>

<script language="javascript" type="text/javascript">
    var url = "{{session("url")}}";
    var artice = 3;
    var intervalid;
    intervalid = setInterval("fun()", 1000);
    function fun() {
        if (artice == 0) {
            if (url == '') {

                window.history.back();
            } else {
                window.location.href = url;

            }

            // window.location.href = "../index.html";
            clearInterval(intervalid);
        }
        document.getElementById("mes").innerHTML = artice;
        artice--;
    }

</script>

</html>
  