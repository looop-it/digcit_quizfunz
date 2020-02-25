<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{trans('home.student_app_form.title')}}</title>
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
    <link rel="stylesheet" type="text/css" href="/home/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/swiper-2.7.6.min.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/datepick.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/valid.css" />
    <script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.3.1.js"></script>

    <style>
        .message-container {
            height: 300px;
            font-szi
        }

        .btn {
            padding: 6px 12px !important;
        }

        a {
            color: white !important;
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

                    <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4 message-container">
                        <div class="section-right">
                            <h2>登記成功</h2>

                            <p></p>
                            <p></p>
                            
                            <p class="message"><h3>您已成功登記</h3><h3></p>
                            <p class="message"><h3>確認電子郵件已傳送至您的信箱，請檢查郵箱並完成驗證<h3></p>

                            <p class="text-center"><a href="{{ route('home') }}" class="btn btn-primary">返回首頁</a></p>
                        </div>
                        
                    </div>
                    
                    @include('home.comm.left_rank')

                </div>
            </div>
        </div>
    </div>
    @include('home.comm.dialog')
    @include('home.comm.foot')

    <script>
        $("form option:nth-child(1)").prop("selected", 'selected');

        $(".register_form").Validform({
            tiptype: function (msg, o, cssctl) {
                //msg：提示信息;
                //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
                //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                if (!o.obj.is("form")) {//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
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
                'name':/^\s*$|^[a-zA-Z0-9 ]{5,15}$/,
                'datename':/^\s*$|^[0-9]{4}$/,
                'password':/^[a-zA-Z0-9]{8,20}$/,
                'phone':/^\s*$|^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/,
            }
        });
    </script>

    <script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="/home/js/bootstrap.js"></script>
    <script type="text/javascript" src="/home/js/datepick.min.js"></script>
    <script type="text/javascript" src="/home/js/zh-cn.js"></script>
    <script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>

    @if($global->total_number > 0)
        @include('home.comm.numRoll')
    @endif
    
    <script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript" src="/home/js/overfloat.js"></script>
</body>

</html>