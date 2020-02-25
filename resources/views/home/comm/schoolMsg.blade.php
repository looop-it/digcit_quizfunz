<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>學校報名成功</title>
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

        p{
            font-size: 20px;
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
                        <h2>成功啟動</h2>
                        <br>
                        <div class="signup">
                            <p>為增進教師對大灣區的了解，進而適切幫助學生認識大灣區，大會將於稍後透過電郵發放比賽介紹簡報、部分題庫，以及比賽海報、大灣區「懶人包」，敬請密切留意。</p>
                            <p>&nbsp;</p>
                        </div>
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


</script>

</html>
  