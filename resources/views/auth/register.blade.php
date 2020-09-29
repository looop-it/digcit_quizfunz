@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="bg-content">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <div class="register-container">
                            <div class="title text-center mb-3">學生登記</div>

                            <form class="form-horizontal" action="{{ route('register') }}" method="POST">
                                {{ csrf_field() }}

                                <div class="form-group @if($errors->has('name')) has-error @endif">
                                    <label for="name" class="col-sm-3 control-label" required>姓名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入電郵地址"
                                            value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('email')) has-error @endif">
                                    <label for="email" class="col-sm-3 control-label" required>電郵地址</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入電郵地址"
                                            value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('email_confirmation')) has-error @endif">
                                    <label for="email_confirmation" class="col-sm-3 control-label" required>確認電郵地址</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email_confirmation" name="email_confirmation"
                                            placeholder="請輸入電郵地址" value="{{ old('email_confirmation') }}" required>

                                        @if ($errors->has('email_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_confirmation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('password')) has-error @endif">
                                    <label for="password" class="col-sm-3 control-label" required>密碼</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="請輸入密碼" required>
                                        
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                                    <label for="password_confirmation" class="col-sm-3 control-label" required>確認密碼</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="請輸入密碼" required>
                                        
                                        @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('mobile')) has-error @endif">
                                    <label for="mobile" class="col-sm-3 control-label">聯絡電話</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            placeholder="請輸入聯絡電話" value="{{ old('mobile') }}">

                                        <span class="help-block">
                                            選填，作聯絡領獎之用
                                        </span>

                                        @if ($errors->has('mobile'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="@if($errors->has('agree_tos')) has-error @endif">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="agree_tos" name="agree_tos" type="checkbox" checked required> 同意免責條款

                                                    @if ($errors->has('agree_tos'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('agree_tos') }}</strong>
                                                    </span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input id="subscribe" name="subscribe" type="checkbox" checked required> 同意接收由主辦機構發出的電子資訊
                                        </label>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-block btn-success">登記</button>
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
    $("[name='email_confirmation']").on('paste', function(e) {
        e.preventDefault();
    });
</script>
@endsection