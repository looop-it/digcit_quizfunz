@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="content-container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-12">
                        <div class="form-container">
                            <div class="title text-center mb-3">重設密碼</div>

                            <form class="form-horizontal" action="{{ route('password.request') }}" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group @if($errors->has('email')) has-error @endif">
                                    <label for="email" class="col-sm-3 control-label">電郵地址</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="請輸入電郵地址"
                                            value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('password')) has-error @endif">
                                    <label for="password" class="col-sm-3 control-label">密碼</label>
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
                                    <label for="password_confirmation" class="col-sm-3 control-label">確認密碼</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                            placeholder="請輸入確認密碼" required>
                                        
                                        @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-danger">重設</button>
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
