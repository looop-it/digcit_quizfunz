@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/home/css/style.css" />
<link rel="stylesheet" type="text/css" href="/home/css/valid.css"/>

<style>
    .container .section .section-right .signup .from>div p {
        font-size: 12px;
        color: red;
    }

    .section .section-right .signup .agree button {
        background: url(/home/img/school.png) no-repeat center;
        background-size: 100% 100%;
    }
</style>
@endsection

@section('content')
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
                                <form method="post" action="{{ route('school_registration.store') }}" class="demoform">
                                    {{ csrf_field() }}
                                    <div class="text-center">
                                        <h4>以下資料將用作發放比賽消息及直接聯絡，請務必確保資料填寫正確</h4>
                                    </div>

                                    <div class="from clearfix">
                                        <div>
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>學校名稱
                                            </label>

                                            <div class="col-md-12 col-sm-12">
                                                <select id="school_id" name="school_id"></select>
                                                @if ($errors->has('school_id'))
                                                    <p>{{ $errors->first('school_id') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>學校地址
                                            </label>
                                            
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="address" placeholder="請輸入學校地址" value="{{ old('address') }}"/>
                                                @if ($errors->has('address'))
                                                    <p>{{ $errors->first('address') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span>負責老師</span>
                                            </label>

                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>姓名
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="name" placeholder="請輸入姓名" value="{{ old('name') }}"/>
                                                @if ($errors->has('name'))
                                                    <p>{{ $errors->first('name') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="span">*</span>負責科目
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" name="subject" placeholder="請輸入負責科目" value="{{ old('subject') }}"/>
                                                @if ($errors->has('subject'))
                                                    <p>{{ $errors->first('subject') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            <label class="col-md-12">
                                                <span class="span">*</span>聯絡電郵
                                            </label>

                                            <div class="col-md-12">
                                                <input type="email" name="email" placeholder="請輸入聯絡電郵" value="{{ old('email') }}"/>
                                                @if ($errors->has('email'))
                                                    <p>{{ $errors->first('email') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            <label class="col-md-12">
                                                <span class="span">*</span>聯絡電話
                                            </label>

                                            <div class="col-md-12">
                                                <input type="text" name="phone" placeholder="請輸入聯絡電話" value="{{ old('phone') }}"/>
                                                @if ($errors->has('phone'))
                                                    <p>{{ $errors->first('phone') }}</p>
                                                @else
                                                    <p></p>
                                                @endif
                                            </div>

                                            {{-- <label class="col-md-12 col-sm-12 col-xs-12"><span
                                                    class="span">*</span>{{trans('home.school_app_form.student_total')}}<span
                                                    class="small">{{trans('home.school_app_form.student_total_hint')}}</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="students" datatype="n1-9"
                                                    nullmsg="{{trans('home.school_app_form_validation.student_total_valid')}}"
                                                    errormsg="{{trans('home.school_app_form_validation.student_total_valid')}}"
                                                    placeholder="{{trans('home.school_app_form_validation.student_total_valid')}}" />
                                                <p class="Validform_checktip"></p>
                                            </div>

                                            <label class="col-md-12 col-sm-12 col-xs-12"><span
                                                    class="span">*</span>{{trans('home.school_app_form.expect_participants_num')}}<span
                                                    class="small">{{trans('home.school_app_form.expect_participants_num_hint')}}</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" value="" name="expected_participants"
                                                    onchange="check_expected_participants('expected_participants')"
                                                    placeholder="{{trans('home.school_app_form_validation.expect_participants_num_valid')}}" />
                                                <p class="Validform_checktip"></p>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="agree">
                                        <label for="agree_edm">
                                            <input type="checkbox" checked="checked" name="agree_edm" id="agree_edm"/>
                                            <span class="vmiddle">{{trans('home.school_app_form.acpt_edm')}}</span>
                                            <p></p>
                                        </label>

                                        <div>
                                            <button type="submit" class="btn" id="submitid"></button>
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
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#school_id').select2({
                theme: "bootstrap",
                data: {!!json_encode($schools)!!},
                allowClear:true,
                placeholder: {
                    id:  "",
                    text: "\u53ef\u641c\u7d22\u7be9\u9078"
                }
            });

            @if (old('school_id'))
                $('#school_id').val({{ old('school_id') }}).trigger('change');
            @endif
        });

        
    </script>
@endsection
