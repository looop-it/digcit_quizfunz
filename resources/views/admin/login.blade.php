<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Gudea:400,700);

        body {
            -webkit-perspective: 800px;
            perspective: 800px;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'Gudea', sans-serif;
            background: #EA5C54;
            /* Old browsers */
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #EA5C54), color-stop(100%, #bb6dec));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(-45deg, #EA5C54 0%, #bb6dec 100%);
            /* Chrome10+,Safari5.1+ */
            /* Opera 11.10+ */
            /* IE10+ */
            background: -webkit-linear-gradient(315deg, #EA5C54 0%, #bb6dec 100%);
            background: linear-gradient(135deg, #EA5C54 0%, #bb6dec 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#EA5C54 ', endColorstr='#bb6dec', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }

        body ::-webkit-input-placeholder {
            color: #4E546D;
        }

        body .authent {
            display: none;
            background: #35394a;
            /* Old browsers */
            /* FF3.6+ */
            background: -webkit-gradient(linear, left bottom, right top, color-stop(0%, #35394a), color-stop(100%, #1f222e));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* Chrome10+,Safari5.1+ */
            /* Opera 11.10+ */
            /* IE10+ */
            background: linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#35394a', endColorstr='#1f222e', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
            position: absolute;
            left: 0;
            right: 90px;
            margin: auto;
            width: 100px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            padding: 20px 70px;
            top: 200px;
            bottom: 0;
            height: 70px;
        }

        body .authent p {
            text-align: center;
            color: white;
        }

        body .success {
            display: none;
            color: #d5d8e2;
        }

        body .error {
            display: none;
            color: #d5d8e2;
        }

        body .success p {
            font-size: 14px;
        }

        body .error p {
            font-size: 14px;
        }

        body .error p a {
            color: #fff;
        }

        body p {
            color: #ccc;
            font-size: 10px;
            text-align: left;
        }

        body .testtwo {
            left: -320px !important;
        }

        body .test {
            box-shadow: 0px 20px 30px 3px rgba(0, 0, 0, 0.55);
            pointer-events: none;
            top: -100px !important;
            -webkit-transform: rotateX(70deg) scale(0.8) !important;
            transform: rotateX(70deg) scale(0.8) !important;
            opacity: .6 !important;
            -webkit-filter: blur(1px);
            filter: blur(1px);
        }

        body .login {
            opacity: 1;
            top: 20px;
            -webkit-transition-timing-function: cubic-bezier(0.68, -0.25, 0.265, 0.85);
            -webkit-transition-property: -webkit-transform, opacity, box-shadow, top, left;
            transition-property: transform, opacity, box-shadow, top, left;
            -webkit-transition-duration: .5s;
            transition-duration: .5s;
            -webkit-transform-origin: 161px 100%;
            -ms-transform-origin: 161px 100%;
            transform-origin: 161px 100%;
            -webkit-transform: rotateX(0deg);
            transform: rotateX(0deg);
            position: relative;
            width: 240px;
            border-top: 2px solid #D8312A;
            height: 300px;
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            top: 0;
            bottom: 0;
            padding: 100px 40px 40px 40px;
            background: #35394a;
            /* Old browsers */
            /* FF3.6+ */
            background: -webkit-gradient(linear, left bottom, right top, color-stop(0%, #35394a), color-stop(100%, #1f222e));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* Chrome10+,Safari5.1+ */
            /* Opera 11.10+ */
            /* IE10+ */
            background: linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#35394a', endColorstr='#1f222e', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }

        body .login .validation {
            position: absolute;
            z-index: 1;
            right: 10px;
            top: 6px;
            opacity: 0;
        }

        body .login .disclaimer {
            position: absolute;
            bottom: 20px;
            left: 35px;
            width: 250px;
        }

        body .login_title {
            color: #fff;
            height: 60px;
            text-align: left;
            font-size: 16px;
        }

        body .login_fields {
            height: 208px;
            position: absolute;
            left: 0;
        }

        body .login_fields .icon {
            position: absolute;
            z-index: 1;
            left: 36px;
            top: 8px;
            opacity: .5;
        }

        body .login_fields input[type='password'] {
            color: #DC6180 !important;
        }

        body .login_fields input[type='text'], body .login_fields input[type='password'] {
            color: #afb1be;
            width: 190px;
            margin-top: -2px;
            background: #32364a;
            left: 0;
            padding: 10px 65px;
            border-top: 2px solid #393d52;
            border-bottom: 2px solid #393d52;
            border-right: none;
            border-left: none;
            outline: none;
            font-family: 'Gudea', sans-serif;
            box-shadow: none;
        }

        body .login_fields__user, body .login_fields__password, body .login_fields__captcha {
            position: relative;
        }

        body .login_fields__submit {
            position: relative;
            top: 35px;
            left: 0;
            width: 80%;
            right: 0;
            margin: auto;
        }

        body .login_fields__submit .forgot {
            float: right;
            font-size: 10px;
            margin-top: 11px;
            text-decoration: underline;
        }

        body .login_fields__submit .forgot a {
            color: #606479;
        }

        body .login_fields__submit input {
            border-radius: 50px;
            background: transparent;
            padding: 10px 50px;
            border: 2px solid #DC6180;
            color: #DC6180;
            text-transform: uppercase;
            font-size: 11px;
            -webkit-transition-property: background, color;
            transition-property: background, color;
            -webkit-transition-duration: .2s;
            transition-duration: .2s;
        }

        #captcha {
            width: 70px;
            float: left;
        }

        .captcha_img {
            display: inline-block;
            float: left;
            margin-left: 8px;
            cursor: pointer;
        }

        body .login_fields__submit input:focus {
            box-shadow: none;
            outline: none;
        }

        body .login_fields__submit input:hover {
            color: white;
            background: #DC6180;
            cursor: pointer;
            -webkit-transition-property: background, color;
            transition-property: background, color;
            -webkit-transition-duration: .2s;
            transition-duration: .2s;
        }

        /* Color Schemes */
        .love {
            position: absolute;
            right: 20px;
            bottom: 0px;
            font-size: 11px;
            font-weight: normal;
        }

        .love p {
            color: white;
            font-weight: normal;
            font-family: 'Open Sans', sans-serif;
        }

        .love a {
            color: white;
            font-weight: 700;
            text-decoration: none;
        }

        .love img {
            position: relative;
            top: 3px;
            margin: 0px 4px;
            width: 10px;
        }

        .brand {
            position: absolute;
            left: 20px;
            bottom: 14px;
        }

        .brand img {
            width: 30px;
        }

        .fa {
            color: #fff;
        }
    </style>
</head>
<body>

<div class='login'>
    <div class='login_title'>
        <span>LOOOP.HK SYSTEM LOGIN</span>
    </div>
    <div class='login_fields'>
        <div class='login_fields__user'>
            <div class='icon'><i class="fa fa-user" aria-hidden="true"></i></div>
            <input name="username" id="username" placeholder='{{ trans('admin.username') }}' value="{{ old('username') }}" type='text'>
            <div class='validation'><i class="fa fa-check" aria-hidden="true"></i></div>
        </div>
        <div class='login_fields__password'>
            <div class='icon'><i class="fa fa-key" aria-hidden="true"></i></div>
            <input name="password" id="password" placeholder='{{ trans('admin.password') }}' type='password'>
            <div class='validation'><i class="fa fa-check" aria-hidden="true"></i></div>
        </div>
        <div class='login_fields__captcha'>
            <div class='icon'><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
            <input name="captcha" id="captcha" placeholder='{{ trans('admin.captcha') }}' type='text' autocomplete="off">
            <img class="captcha_img" src="{{ captcha_src() }}" alt="Click to refresh" title="Click to refresh">
            <div class='validation'><i class="fa fa-check" aria-hidden="true"></i></div>
            {{ csrf_field() }}
        </div>
        <div class='login_fields__submit'>
            <input type='submit' value='{{ trans('admin.login') }}'>
            <div class='forgot'>
                <a href='#' onclick="javascript:alert('Please contact your system administrator!')">Forgot password?</a>
            </div>
        </div>
    </div>
    <div class='success'>
        <h2>Welcome Back!</h2>
        {{-- <p>Welcome Back!</p> --}}
    </div>
    <div class='error'>
        <h2>Error</h2>
        <p class="error-msg">Captcha/Username/password do not match. </p>
        <p><a href="/{{config('admin.route.prefix')}}">Try again.</a></p>
    </div>
    <div class='disclaimer'>
        <p>Copyright © {{ date("Y")  }} Looop Media Ltd. All rights reserved</p>
    </div>
</div>
<div class='authent'>
    {{-- <img src='img/puff.svg'> --}}
    <p>Logining...</p>
</div>
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<script src="{{ admin_asset("/bower/jquery-ui/jquery-ui.min.js")}} "></script>
<!--  <script type="text/javascript" src='js/stopExecutionOnTimeout.js?t=1'></script>
  <script src="http://www.jq22.com/jquery/1.11.1/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="js/jquery-ui.min.js"></script> -->
<script>
    $('.captcha_img').on('click', function () {
        refresh_captcha();
    });

    function refresh_captcha() {
        $captcha = $('.captcha_img');
        $captcha.attr('src', $captcha.attr('src') + '?' + (new Date()).valueOf());
    }

    $('input[type="submit"]').click(function () {
        $('.login').addClass('test');
        setTimeout(function () {
            $('.login').addClass('testtwo');
        }, 300);
        setTimeout(function () {
            $('.authent').show().animate({right: -320}, {
                easing: 'easeOutQuint',
                duration: 600,
                queue: false
            });
            $('.authent').animate({opacity: 1}, {
                duration: 200,
                queue: false
            }).addClass('visible');
        }, 500);
        setTimeout(function () {
            $('.authent').show().animate({right: 90}, {
                easing: 'easeOutQuint',
                duration: 600,
                queue: false
            });
            $('.authent').animate({opacity: 0}, {
                duration: 200,
                queue: false
            }).addClass('visible');
            $('.login').removeClass('testtwo');
        }, 1500);
        setTimeout(function () {
            $('.login').removeClass('test');
            // $('.login div').fadeOut(123);
        }, 1800);

        $url_redirect = "{{ session()->has('redirect_url') ? session('redirect_url') : ('/' . config('admin.route.prefix')) }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "{{ admin_base_path('auth/login') }}",
            data: {
                "username": $('#username').val(),
                "password": $('#password').val(),
                "captcha": $('#captcha').val(),
                "_token": $('input[name="_token"]').val()
            },
            error: function () {
                refresh_captcha();
            },
            success: function (data) {
                refresh_captcha();
                if (data.status) {
                    $('.login div').fadeOut(123);
                    $('.success').show();
                    setTimeout(function () {
                        window.location = $url_redirect;
                    }, 2800);
                } else {
                    $('.login div').fadeOut(123);
                    $('.error').show();
                }

            }
        });
    });
/*
    $('input[type="text"],input[type="password"]').focus(function () {
        $(this).prev().animate({'opacity': '1'}, 200);
    });
    $('input[type="text"],input[type="password"]').blur(function () {
        $(this).prev().animate({'opacity': '.5'}, 200);
    });
    $('input[type="text"],input[type="password"]').keyup(function () {
        if (!$(this).val() == '') {
            $(this).next().animate({
                'opacity': '1',
                'right': '30'
            }, 200);
        } else {
            $(this).next().animate({
                'opacity': '0',
                'right': '20'
            }, 200);
        }
    });
    var open = 0;
    $('.tab').click(function () {
        $(this).fadeOut(200, function () {
            $(this).parent().animate({'left': '0'});
        });
    });
    */
</script>
</body>
</html>