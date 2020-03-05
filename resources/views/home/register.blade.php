<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{trans('home.school_app_form.title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    
    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/style.css" />
    <script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/home/js/Validform_v5.3.1.js"></script>
    <style>
        .container .section .section-right .signup .from>div p {
            font-size: 12px;
            color: red;
        }

        .section .section-right .signup .agree button {
            background: url(/home/img/school.png) no-repeat center;
            background-size: 100% 100%;
        }

        /* 			.fe{color:red !important;}
         .container from a:hover{color:blue !important;}  */
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
                    <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
                        <div class="section-right">
                            <h2>{{trans('home.school_app_form.title')}}</h2>
                            <div class="signup">
                                <h1>{{trans('home.school_app_form.please_sign_up_now')}}</h1>
                                <h1>{{trans('home.school_app_form.dawan_district_academic_knowledge_competition')}}</h1>
                                <form action="" method="post" onsubmit="return checkLength()" class="demoform">
                                    <div class="from clearfix">
                                        <div>
                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.school_app_form.school_name')}}</label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="school" ajaxurl="{{url('valid/school')}}"  datatype="*2-255" nullmsg="{{trans('home.school_app_form_validation.school_name_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.school_name_valid')}}" placeholder="{{trans('home.school_app_form_validation.school_name_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>
                                            <!--<div>{{trans('home.school_app_form.contact_person1')}}<span>{{trans('home.school_app_form.contact_person1_hint')}}</span></div>-->
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                            <span>{{trans('home.school_app_form.contact_person1')}}</span>
                                            <span class="small">{{trans('home.school_app_form.contact_person1_hint')}}</span>
                                        </label>
                                        
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>
                                                {{trans('home.school_app_form.contact_person1_name')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="userName" value="" datatype="*2-20" nullmsg="{{trans('home.school_app_form_validation.contact_person1_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person1_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person1_valid')}}"
                                                />
                                                <p id="err_name" class="Validform_checktip"></p>
                                            </div>

                                            {{-- Teching subject --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>
                                                {{trans('home.school_app_form.contact_person1_teaching_subject')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="teachingSubject" value="" datatype="*2-50" nullmsg="{{trans('home.school_app_form_validation.contact_person1_teaching_subject_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person1_teaching_subject_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person1_teaching_subject_valid')}}"
                                                />
                                                <p id="err_name" class="Validform_checktip"></p>
                                            </div>

                                            {{-- Email --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.school_app_form.contact_person1_email')}}</label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" value="" name="email" ajaxurl="{{url('valid/school')}}" datatype="e" nullmsg="{{trans('home.school_app_form_validation.contact_person1_email_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person1_email_format_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person1_email_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.school_app_form.contact_person1_tel')}}</label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="tel" value="" name="phone" ajaxurl="{{url('valid/school')}}"  datatype="phone" nullmsg="{{trans('home.school_app_form_validation.contact_person1_tel_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person1_tel_format_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person1_tel_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>
                                            <!--<div>{{trans('home.school_app_form.contact_person2')}}<span>{{trans('home.school_app_form.contact_person2_hint')}}</span></div>-->
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                            <span>{{trans('home.school_app_form.contact_person2')}}</span>
                                            <span class="small">{{trans('home.school_app_form.contact_person2_hint')}}</span>
                                        </label>
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                            {{trans('home.school_app_form.contact_person2_name')}}
                                        </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="userName2"  value="" nullmsg="{{trans('home.school_app_form_validation.contact_person2_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person2_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person2_valid')}}"
                                                />
                                                <p id="err_name" class="Validform_checktip"></p>
                                            </div>

                                            {{-- Teching subject --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                {{trans('home.school_app_form.contact_person2_teaching_subject')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="teachingSubject2"  value="" nullmsg="{{trans('home.school_app_form_validation.contact_person2_teaching_subject_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person2_teaching_subject_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person2_teaching_subject_valid')}}"
                                                />
                                                <p id="err_name" class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.school_app_form.contact_person2_email')}}</label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" value="" name="email2" datatype="e2" nullmsg="{{trans('home.school_app_form_validation.contact_person2_email_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person2_email_format_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person2_email_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>
                                            <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.school_app_form.contact_person2_tel')}}</label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="tel" value="" name="phone2" datatype="phone2" nullmsg="{{trans('home.school_app_form_validation.contact_person2_tel_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.contact_person2_tel_format_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.contact_person2_tel_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.school_app_form.fax')}}</label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="fax" datatype="fax" nullmsg="{{trans('home.school_app_form_validation.fax_valid')}}" errormsg="{{trans('home.school_app_form_validation.tel_format_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.fax_valid')}}" />
                                                <p class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.school_app_form.student_total')}}<span class="small">{{trans('home.school_app_form.student_total_hint')}}</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="students" datatype="n1-9" nullmsg="{{trans('home.school_app_form_validation.student_total_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.student_total_valid')}}" placeholder="{{trans('home.school_app_form_validation.student_total_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.school_app_form.expect_participants_num')}}<span class="small">{{trans('home.school_app_form.expect_participants_num_hint')}}</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="expected_participants" onchange="check_expected_participants('expected_participants')"
                                                    placeholder="{{trans('home.school_app_form_validation.expect_participants_num_valid')}}"
                                                />
                                                <p class="Validform_checktip"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="agree">
                                        <label for="">
                                        <input type="checkbox" checked="checked" name="vmiddle" id="vmiddle" value="" onchange="viem()"/>
                                        <span class="vmiddle">{{trans('home.school_app_form.acpt_edm')}}</span>
                                        <p></p>
                                    </label>
                                        <div>
                                            <button class="btn" id="submitid"></button>
                                        </div>
                                    </div>
                                </form>

                                {{-- <div class="star starStu">
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
    @include('home.comm.dialog')
    @include('home.comm.foot')

    <script>
        function checkLength() {

        return false;
    }
    function viem() {
        var ns = $('#vmiddle').next();
        if (!document.getElementById("vmiddle").checked) {

            ns.css("color", "red");
            return false;
        } else {

            ns.css("color", "#00559B");
            return true;
        }

    }

    function check_expected_participants(expected_participants){

        var userNameNode = document.getElementsByName(expected_participants)[0];
        var ns=getNextSibilingsNode(userNameNode);
        var phoneName = document.getElementsByName(expected_participants)[0].value;
        var regPhone = /^[0-9]*$/;
        if (phoneName == "" || phoneName.trim() == "") {
            ns.innerHTML = "{{trans('home.school_app_form_validation.expect_participants_num_valid')}}";
            ns.style.color = "red";
            return false;
        } else if (!regPhone.test(phoneName) || phoneName<50) {
            ns.innerHTML = "{{trans('home.school_app_form_validation.expect_participants_num_valid')}}";
            ns.style.color = "red";
            return false;
        } else {
            ns.innerHTML = "";
            ns.style.color = "#71b83d";
            return true;
        }

    }


    function getNextSibilingsNode(ele) {
        var parsent = ele.parentNode;//获取元素父元素
        var childrens = parsent.childNodes;//获取兄弟元素
        var i = 0;
        for(i; i < childrens.length; i++) {
            if(childrens[i].nodeType == 1 && childrens[i] == ele){//元素节点nodeType值为1，剔除文本节点
                if(childrens[i+1].nodeType == 1){//防止li之间没有换行，直接选择下一个i+1
                    return childrens[i+1];
                }if(childrens[i+2].nodeType == 1){//跳过文本节点，所以i+2
                    return childrens[i+2];
                }
                else{
                    throw error("传入的元素出错，请检查，可能这是最后一个元素");
                }
            }
        }
    }



        var demo= $(".demoform").Validform({

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


        beforeSubmit:function(curform){
            //在验证成功后，表单提交前执行的函数，curform参数是当前表单对象。
            //这里明确return false的话表单将不会提交;


            if (!check_expected_participants('expected_participants')) return false;

            if (!viem()) return false;
            var school = document.getElementsByName("school")[0].value;
            var name = document.getElementsByName("userName")[0].value;
            var teachingSubject = document.getElementsByName("teachingSubject")[0].value;
            var email = document.getElementsByName("email")[0].value;
            var phone = document.getElementsByName("phone")[0].value;
            var name2 = document.getElementsByName("userName2")[0].value;
            var teachingSubject2 = document.getElementsByName("teachingSubject2")[0].value;
            var email2 = document.getElementsByName("email2")[0].value;
            var phone2 = document.getElementsByName("phone2")[0].value;
            var fax = document.getElementsByName("fax")[0].value;
            var students = document.getElementsByName("students")[0].value;
            var expected_participants = document.getElementsByName("expected_participants")[0].value;

            var data = {
                '_token': '{{csrf_token()}}',
                'contact': name,
                'teaching_subject': teachingSubject,
                'email': email,
                'phone': phone,
                'contact2': name2,
                'teaching_subject2': teachingSubject2,
                'email2': email2,
                'phone2': phone2,
                'fax': fax,
                'student': students,
                'name': school,
                'expected_participant': expected_participants
            };

            console.log(data);

            $.ajax({
                url: "{{ route('school.store') }}",//要请求的servlet
                data: data,
                type: "POST",
                dataType: "json",
                async: false,//是否异步请求，如果是异步，那么不会等服务器返回，我们这个函数就向下运行了。
                cache: false,
                success: function (result) {
                    $('#msg').html(result.msg);

                    if (result.state == 0) {
                        $('#myModal').modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false
                        })
                        //定时执行，5秒后执行
                        var t1 = setTimeout(function () {
                            window.clearTimeout(t1);
                        }, 5000)
                    } else {
                        $('#myModal').modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false
                        })

                        //定时执行，5秒后执行
                        var t1 = setTimeout(function () {


                            window.clearTimeout(t1);
                        }, 5000)


                    }
                }
            });




        },

        datatype: {
            'fax': /^\s*$|^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/,
            'phone':/^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/,
//            'name2':/^\s*$|^[\u0391-\uFFE5a-zA-Z·.。;&\\s]{0,20}$/,
            'phone2':/^\s*$|^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/,
            'e2':/^\s*$|^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/,
        },
        callback:function(data){
           // http://validform.club/document.html#initialize

            //返回数据data是json对象，{"info":"demo info","status":"y"}
            //info: 输出提示信息;
            //status: 返回提交数据的状态,是否提交成功。如可以用"y"表示提交成功，"n"表示提交失败，在ajax_post.php文件返回数据里自定字符，主要用在callback函数里根据该值执行相应的回调操作;
            //你也可以在ajax_post.php文件返回更多信息在这里获取，进行相应操作；
            //ajax遇到服务端错误时也会执行回调，这时的data是{ status:**, statusText:**, readyState:**, responseText:** }；

            //这里执行回调操作;
            //注意：如果不是ajax方式提交表单，传入callback，这时data参数是当前表单对象，回调函数会在表单验证全部通过后执行，然后判断是否提交表单，如果callback里明确return false，则表单不会提交，如果return true或没有return，则会提交表单。
        }



    });



    $('#submitid').click(function () {

//        if (!check_Shool('school')) return false;
//
//        if (!check_contactPerson("userName")) return false;
//
//        if (!check_email('email')) return false;
//
//        if (!check_phone('phone')) return false;
//
//        if (!check_fax('fax')) return false;
//
//
//        if (!check_students('students')) return false;
//
//        if (!check_expected_participants('expected_participants')) return false;



    });
    </script>
    <script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="/home/js/bootstrap.js"></script>
    <script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="/home/js/overfloat.js"></script>
    {{--
    <script type="text/javascript" src="/home/js/jsajax.js"></script>--}}
    @if($global->total_number > 0)
        @include('home.comm.numRoll')
    @endif

    <script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
</body>

</html>