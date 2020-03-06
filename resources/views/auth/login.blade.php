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

    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/valid.css"/>
    <script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script>
    <style>
        .checktip {
            color:red;
        }
    </style>
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
                <div class="col-md-8 col-sm-12 col-xs12 col-md-push-4">
                    <div class="section-right">
                        <h2>
                            {{trans('home.login.title')}}
                            <a href="{{ route('register') }}">{{trans('home.login.registered')}}</a>
                        </h2>
                        <div class="signup">
                            <h1>{{trans('home.login.please_login_member')}} ！</h1>
                            <h3>即可參與「歷史在線」挑戰賽</h3>
                            <form action="{{ route('login') }}" method="post" class="demoform" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="from clearfix">
                                    <div>
                                        <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.login.account_number_mailbox')}}</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" name="email" value=""
                                                   placeholder="{{trans('home.login.please_input_your_email')}}" vali
                                                   datatype="e" nullmsg="{{trans('home.login.please_input_your_email')}}" errormsg="{{trans('home.login.incorrect_mailbox_format')}}"/>
                                            @if ($errors->has('email'))
                                                <p class="Validform_checktip checktip">{{ $errors->first('email') }}</p>
                                            @else
                                                <p class="Validform_checktip"></p>
                                            @endif
                                        </div>
                                        <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.login.password')}}</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="password" value="" name="password"
                                                   placeholder="{{trans('home.login.password_valid')}}" datatype="*8-20" nullmsg="{{trans('home.login.password_valid')}}"
                                                   errormsg="{{trans('home.login.password_rule')}}"/>
                                            @if ($errors->has('password'))
                                                <p class="Validform_checktip checktip">{{ $errors->first('password') }}</p>
                                            @else
                                                <p class="Validform_checktip"></p>
                                            @endif
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <a href="https://www.looop.hk/password/reset" target="new">{{trans('home.login.forgot_password')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="agree">
                                    <div class="login">
                                        <button class="btn"><!--{{trans('home.login.sign_in')}}--></button>
                                    </div>
                                </div>

                                <div id="login_form"></div>

                                {!!  GoogleReCaptchaV3::render([
                                    'login_form'=>'login'
                                ]) !!}
                            </form>
                            {{-- <div class="star starStu">
                                <img src="/home/img/star.png"/>
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
<script type="text/javascript">

    //
    //  $(".demoform").Validform();
    $(".demoform").Validform({
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
            'datenoe': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/,

        }
    });
</script>
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
