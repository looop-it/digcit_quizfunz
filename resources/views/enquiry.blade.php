@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content-container">
                    <div class="row">
                        @include('left_panel')
                        
                        <div class="col-md-8 col-sm-12">
                            <div class="section-container">
                                <div class="section-title mb-3">聯絡我們</div>
    
                                <div class="section-content">
                                    <div class="mb-3">
                                        <strong>如你對「歷史在線」挑戰賽2.0 有任何查詢，請填妥以下表格。</strong>
                                    </div>

                                    <form action="{{ route('enquiry.store') }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}

                                        <div class="form-group @if($errors->has('name')) has-error @endif">
                                            <label for="name" class="col-sm-3 control-label" required>姓名</label>
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

                                        <div class="form-group @if($errors->has('school_name')) has-error @endif">
                                            <label for="school_name" class="col-sm-3 control-label" required>學校名稱</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="school_name" name="school_name" placeholder="請輸入學校名稱"
                                                    value="{{ old('school_name') }}" required>
        
                                                @if ($errors->has('school_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('school_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group @if($errors->has('tel')) has-error @endif">
                                            <label for="tel" class="col-sm-3 control-label" required>聯絡電話</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tel" name="tel" placeholder="請輸入聯絡電話"
                                                    value="{{ old('tel') }}" required>
        
                                                @if ($errors->has('tel'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tel') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group @if($errors->has('email')) has-error @endif">
                                            <label for="email" class="col-sm-3 control-label" required>電郵地址</label>
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

                                        <div class="form-group @if($errors->has('enquiry')) has-error @endif">
                                            <label for="enquiry" class="col-sm-3 control-label" required>查詢內容</label>
                                            <div class="col-sm-9">
                                                <textarea name="enquiry" id="enquiry" cols="30" rows="10" class="form-control">{{ old('enquiry') }}</textarea>
                                                
                                                @if ($errors->has('enquiry'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('enquiry') }}</strong>
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
                                                <button type="submit" class="btn btn-block btn-main">提交</button>
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
    </div>
@endsection
