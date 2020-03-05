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
    <link rel="stylesheet" type="text/css" href="/home/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/valid.css" />
    <script type="text/javascript" src="/home/js/jquery-1.6.2.min.js"></script>
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
                            <h2>{{trans('home.student_app_form.title')}}</h2>
                            <div class="signup">
                                <h1>{{trans('home.student_app_form.please_sign_up_now')}}</h1>
                                <h1>請即報名參加「歷史在線」挑戰賽</h1>

                                @if ($errors->any())
                                    <br />
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <form action="{{ route('register') }}" method="POST" class="register_form">
                                    {{ csrf_field() }}
                                    <div class="from clearfix">
                                        <div>
                                            {{-- Email address --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>{{trans('home.student_app_form.email')}}<span class="small">{{trans('home.student_app_form.email_hint')}}</span>
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" name="email" value="{{ old('email') }}" required />
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Email address --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>{{trans('home.student_app_form.email_confirmed')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" name="email_confirmation" value="{{ old('password_confirmation') }}" required />
                                                <p>&nbsp;</p>
                                            </div>
                                            
                                            {{-- Password --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>
                                                {{trans('home.student_app_form.password')}}
                                                <span class="small">{{trans('home.student_app_form.password_hint')}}</span>
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="password" name="password" placeholder="{{trans('home.student_app_form.please_enter_your_password')}}" minlength="8" maxlength="20" required />
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Confirm password --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12"><span class="span">*</span>{{trans('home.student_app_form.confirm_password')}}<span class="small">{{trans('home.student_app_form.confirm_password_hint')}}</span></label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="password" name="password_confirmation" datatype="password" placeholder="{{trans('home.student_app_form.please_enter_your_password')}}" required />
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Nickname --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.student_app_form.acc_name')}}<span class="small">{{trans('home.student_app_form.acc_name_hint')}}</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="name" placeholder="{{trans('home.student_app_form_validation.acc_name_valid')}}" value="{{ old('name') }}" />
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Mobile number --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                {{trans('home.student_app_form.tel')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="tel" name="mobile" placeholder="{{trans('home.student_app_form_validation.tel_valid')}}" minlength="8" maxlength="8" value="{{ old('mobile') }}"/>
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Gender --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                {{trans('home.student_app_form.gender')}}
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="gender" id="gender">
                                                    <option value="m">{{trans('home.student_app_form.m')}}</option>
                                                    <option value="f">{{trans('home.student_app_form.f')}}</option>
                                                </select>
                                                <p>&nbsp;</p>
                                            </div>

                                            {{-- Birthday --}}
                                            <label class="col-md-12 col-sm-12 col-xs-12">{{trans('home.student_app_form.dob')}}</label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select name="birthday_year" id="birthday_year">
                                                        @foreach (range(1900, now()->year) as $year)
                                                            <option value="{{ $year }}">{{ $year }}年</option>
                                                        @endforeach
                                                    </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <select name="birthday_month" id="birthday_month">
                                                            @foreach (range(1, 12) as $month)
                                                                <option value="{{ $month }}">{{ $month }}月</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="sst"> </div>
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="agree">
                                        <label for="subscribe" style="margin-left: 17px;">
                                            <input type="checkbox" checked="checked" name="subscribe" id="subscribe" />
                                            <span class="span">*</span>
                                            <span class="vmiddle" >{{trans('home.student_app_form.acpt_edm')}}</span>
                                            <p></p>
                                        </label>

                                        <label for="agree" style="margin-left: 17px;">
                                            <input type="checkbox" checked="checked" name="agree" id="agree" required />
                                            <span class="span">*</span>
                                            <span class="vmiddle" >啟動參賽帳戶，並同意成為Youthinkers及Looop.hk之會員</span>
                                            <p></p>
                                        </label>
                                        <div>
                                            <button class="btn" id="submitid"></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="star starStu">
                                    <img src="/home/img/star.png" />
                                </div>
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
    <script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript" src="/home/js/overfloat.js"></script>

    <script>
        $("#birthday_year").val(2005);

        $("[name='email_confirmed']").on('paste', function(e) {
            e.preventDefault();
        });
    </script>
</body>

</html>