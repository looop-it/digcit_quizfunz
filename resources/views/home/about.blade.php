<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$slug}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/valid.css"/>
    <script type="text/javascript"
            src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.1_min.js"></script>
    <style>
        .section .section-right > div > div > div:nth-child(1) img {
            width: inherit;
            position: static;
        }

        .section .section-right .about #about-content .header_logo, .section .section-right .about #about-content .header_menu {
            width: 50%;
        }

        .section .section-right h2 {
            height: inherit;
        }

        .content-box {
            word-wrap: break-word;
            width: 100%;
        }

        .content-box img {
            width: 100% !important;
        }
        #captcha{cursor: pointer}

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
                        <div>
                            @if(Agent::isMobile())
                                @include('home.comm.header')
                            @endif
                        </div>
                    </div>
                </div>

                <div class=" col-md-8 col-sm-12 col-xs-12 col-md-push-4">
                    <div class="section-right about-right">
                                        <h2>{{$page->name}}</h2>

                                        <div class="content-box">

                                            @if($page->name != '聯絡我們')
                                                {!!$page->content!!}
                                            @else
                                                <div class="content-box">
                                                <div style="padding: 20px 0;">
                                                    <h4>{{trans('home.contact_form.dec')}}</h4>
                                                    <form action="" method="post" class="demoform" onsubmit="return checkLength()">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <div class="from clearfix">
                                                            <div>
                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.name')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="name" value=""
                                                                           placeholder="{{trans('home.contact_form_validation.name_valid')}}"
                                                                           vali
                                                                           datatype="*1-255"
                                                                           nullmsg="{{trans('home.contact_form_validation.name_valid')}}"
                                                                           errormsg="{{trans('home.contact_form_validation.name_valid')}}"/>
                                                                    <p class="Validform_checktip">
                                                                    </p>
                                                                </div>
                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.school_name')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" value="" name="school_name"
                                                                           placeholder="{{trans('home.contact_form_validation.school_name_valid')}}"
                                                                           datatype="*1-255"
                                                                           nullmsg="{{trans('home.contact_form_validation.school_name_valid')}}"
                                                                           errormsg="{{trans('home.contact_form_validation.school_name_valid')}}"/>
                                                                    <p class="Validform_checktip"></p>
                                                                </div>

                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.capacity')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <select name="capacity" id="capacity" cannot="no" vali
                                                                            datatype="*"
                                                                            nullmsg="{{trans('home.contact_form_validation.name')}}"
                                                                            errormsg="{{trans('home.contact_form_validation.name')}}"
                                                                            onchange="selsetext(this)">
                                                                        <option value="" disabled="disabled"
                                                                                selected="selected">{{trans('home.contact_form.please_choose')}}</option>
                                                                        <option value="老師/學校代表">{{trans('home.contact_form.capacity_opt1')}}</option>
                                                                        <option value="學生">{{trans('home.contact_form.capacity_opt2')}}</option>
                                                                        <option value="其他">{{trans('home.contact_form.capacity_opt3')}}</option>
                                                                    </select>
                                                                    <input type="text" name="capacityother"  id="selcet-else"
                                                                           style="display:none;"
                                                                           placeholder="{{trans('home.contact_form_validation.capacity_valid')}}"/>
                                                                    <p class="Validform_checktip"></p>
                                                                </div>


                                                                {{--<div class="col-md-8 col-sm-8 col-xs-12">--}}
                                                                {{--<input type="text" value="" name="capacity"--}}
                                                                {{--placeholder="{{trans('home.contact_form.capacity')}}"--}}
                                                                {{--datatype="*"--}}
                                                                {{--errormsg="{{trans('home.contact_form_validation.name')}}"/>--}}
                                                                {{--<p class="Validform_checktip">{{trans('home.contact_form_validation.name')}}</p>--}}
                                                                {{--</div>--}}


                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.tel')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" value="" name="tel"
                                                                           placeholder="{{trans('home.contact_form_validation.tel_valid')}}"
                                                                           datatype="tel"
                                                                           nullmsg="{{trans('home.contact_form_validation.tel_valid')}}"
                                                                           errormsg="{{trans('home.contact_form_validation.tel_format_valid')}}"/>
                                                                    <p class="Validform_checktip"></p>
                                                                </div>
                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.email')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" value="" name="email"
                                                                           placeholder="{{trans('home.contact_form_validation.email_valid')}}"
                                                                           datatype="e"
                                                                           nullmsg="{{trans('home.contact_form_validation.email_valid')}}"
                                                                           errormsg="{{trans('home.contact_form_validation.email_format_valid')}}"/>
                                                                    <p class="Validform_checktip"></p>
                                                                </div>
                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.enquiry')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <textarea type="text" value="" name="enquiry"
                                                                              placeholder="{{trans('home.contact_form_validation.enquiry_valid')}}"
                                                                              datatype="*"
                                                                              nullmsg="{{trans('home.contact_form_validation.enquiry_valid')}}"
                                                                              errormsg="{{trans('home.contact_form_validation.enquiry_valid')}}"></textarea>
                                                                    <p class="Validform_checktip"></p>
                                                                </div>
                                                                <label class="col-md-8 col-sm-8 col-xs-12">{{trans('home.contact_form.captcha')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="captcha" datatype="*" nullmsg="{{trans('home.contact_form_validation.captcha')}}"  >
                                                                    <p class="Validform_checktip"></p>
                                                                    <img src="{{captcha_src()}}"
                                                                         style="width: 120px;margin:5px auto;"
                                                                         onclick="this.src='{{captcha_src()}}?'+Math.random()"
                                                                         id="captcha"/>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="agree">
                                                            <div class="login">
                                                                <button class="btn" id="submitid"></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                            @endif

                                        </div>


                    </div>
                    
                </div>

                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@include('home.comm.foot')
@include('home.comm.dialog')
<script type="text/javascript">

    //
    //  $(".demoform").Validform();
    $(".demoform").Validform({
        tiptype: function (msg, o, cssctl) {
            //msg：提示信息;
            //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
            //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
            if (!o.obj.is("form")) {//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                if (o.type != 2) {
                    var objtip = o.obj.siblings(".Validform_checktip");
                    cssctl(objtip, o.type);
                    objtip.text(msg);
                } else {
                    o.obj.siblings(".Validform_checktip").html("");
                }
            }
        },

        beforeSubmit: function (curform) {
            //在验证成功后，表单提交前执行的函数，curform参数是当前表单对象。
            //这里明确return false的话表单将不会提交;

            actionajax();

        },

        datatype: {
            'select': /^[^no]$/,
            'tel': /^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/,
            'datenoe': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/,

        }
    });

    function checkLength() {

        return false;
    }

    function actionajax() {


        var name = document.getElementsByName("name")[0].value;
        var school_name = document.getElementsByName("school_name")[0].value;
        var capacity = document.getElementsByName("capacity")[0].value;
        var tel = document.getElementsByName("tel")[0].value;
        var email = document.getElementsByName("email")[0].value;
        var enquiry = document.getElementsByName("enquiry")[0].value;
        var captcha = document.getElementsByName("captcha")[0].value;
        var capacityother = document.getElementsByName("capacityother")[0].value;

        if (capacity == '其他') {
            capacity = capacityother;
        }

        $.ajax({
            url: "/pages/enquiry",//要请求的servlet
            data: {
                '_token': '{{csrf_token()}}',
                'name': name,
                'school_name': school_name,
                'capacity': capacity,
                'tel': tel,
                'email': email,
                'enquiry': enquiry,
                'captcha': captcha

            },//给服务器的参数
            type: "POST",
            dataType: "json",
            async: false,//是否异步请求，如果是异步，那么不会等服务器返回，我们这个函数就向下运行了。
            cache: false,
            success: function (result) {
                $('#captcha').attr('src', '{{captcha_src()}}?' + Math.random());
                $('#msg').html(result.msg);
                if (result.state == 0) {
                    $('#myModal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false
                    })

                    //定时执行，5秒后执行
                    var t1 = setTimeout(function () {
                /*        $('.fade.in').css('opacity',0);
                        $('.modal-backdrop').css('opacity',0);
                        $(".modal-backdrop").remove();*/
                        window.clearTimeout(t1);
                    }, 5000)


                } else {
                    $('#myModal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false
                    })

                    $("form")[0].reset();

                    //定时执行，5秒后执行
                    var t1 = setTimeout(function () {
                     /*   $('.fade.in').css('opacity',0);
                        $('.modal-backdrop').css('opacity',0);
                        $(".modal-backdrop").remove();*/
                        window.clearTimeout(t1);
                    }, 5000)


                }
            }
        });

    }

    function selsetext(obj) {
        if (obj.options[obj.selectedIndex].value == "其他") {
            document.getElementById("selcet-else").style.display = "";
        } else {
            document.getElementById("selcet-else").style.display = "none";
        }
    }
</script>
<script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
<script type="text/javascript" src="/home/js/bootstrap.js"></script>
<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
@if($global->total_number > 0)
    @include('home.comm.numRoll')
@endif
<script type="text/javascript" src="/home/js/overfloat.js"></script>
<!--<script src="/home/js/select.js" type="text/javascript" charset="utf-8"></script>-->
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
