@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">

                    <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <div class="form-container">
                            <div class="title text-center mb-3">學校登記</div>

                            <form class="form-horizontal" method="post" action="{{ route('school_registration.store') }}" class="demoform">
                                {{ csrf_field() }}

                                <div class="alert alert-danger text-center">
                                    注意：此登記表格只供學校老師使用，學生參賽者請使用「<a href="{{ sso_url('register') }}">學生登記</a>」表格
                                </div>

                                <div class="text-center mb-3">
                                    <strong>以下資料將用作發放比賽消息及直接聯絡，請務必確保資料填寫正確</strong>
                                </div>

                                <div class="form-group @if($errors->has('name')) has-error @endif">
                                    <label for="name" class="col-sm-3 control-label" required>學校名稱</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="school_id" name="school_id"></select>
                                        如未能在列表中找到您的學校，請<a href="{{ route('enquiry') }}">聯絡我們</a>

                                        @if ($errors->has('school_id'))
                                            <p>{{ $errors->first('school_id') }}</p>
                                        @else
                                            <p></p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('address')) has-error @endif">
                                    <label for="address" class="col-sm-3 control-label" required>學校地址</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="請輸入學校地址"
                                            value="{{ old('address') }}" required>

                                        @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('students')) has-error @endif">
                                    <label for="students" class="col-sm-3 control-label" required>學生人數</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="students" name="students" placeholder="請輸入學生人數"
                                            value="{{ old('students') }}" required>

                                        @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('students') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('name')) has-error @endif">
                                    <label for="name" class="col-sm-3 control-label" required>負責老師姓名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名"
                                            value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('subject')) has-error @endif">
                                    <label for="subject" class="col-sm-3 control-label" required>負責科目</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="請輸入負責科目"
                                            value="{{ old('subject') }}" required>

                                        @if ($errors->has('subject'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('email')) has-error @endif">
                                    <label for="email" class="col-sm-3 control-label" required>聯絡電郵</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="請輸入聯絡電郵"
                                            value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('phone')) has-error @endif">
                                    <label for="phone" class="col-sm-3 control-label" required>聯絡電話</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="請輸入聯絡電話"
                                            value="{{ old('phone') }}" required>

                                        @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3"></label>
                                    <div class="col-sm-9">
                                        <div id="g-recaptcha"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="@if($errors->has('agree_edm')) has-error @endif">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="agree_edm" name="agree_edm" type="checkbox" checked required> 同意接收由主辦機構發出的電子資訊

                                                    @if ($errors->has('agree_edm'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('agree_edm') }}</strong>
                                                    </span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn-image"><img src="/home/img/submit_register.png" class="img-fluid"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                data: @json($schools),
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
