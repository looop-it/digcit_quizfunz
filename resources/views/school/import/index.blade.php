@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-12" style="padding:50px;">
                        <form class="form-horizontal" method="post" action="{{ route('student_account_import.login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">電郵地址</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="請輸入電郵地址" value="{{ $data ? $data['email'] : '' }}">

                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="token" class="col-sm-3 control-label">驗證碼</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="token" name="token" placeholder="請輸入驗證碼" value="{{ $data ? $data['token'] : '' }}">

                                    @if ($errors->has('token'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('token') }}</strong>
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
                                    <button type="submit" class="btn btn-block btn-success">確認</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>
<script>
    var onloadCallback = function() {
      widgetId = grecaptcha.render('g-recaptcha', {
        'sitekey' : '{{ config('googlerecaptchav2.site_key') }}',
      });
    };
</script>
@endsection