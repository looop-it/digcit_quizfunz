@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    @include('user_left_panel')

                    <div class="col-md-8 col-sm-12">
                        <div class="section-container">
                            <div class="page-header">
                                <h3>帳戶資料</h3>
                            </div>

                            <div class="section-content">
                                <form class="form-horizontal" >
                                    {{ csrf_field() }}
    
                                    <div class="form-group @if($errors->has('name')) has-error @endif">
                                        <label for="name" class="col-sm-3 control-label" required>賬號</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" readonly>
    
                                        </div>
                                    </div>
    
                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                        <label for="email" class="col-sm-3 control-label" required>電郵地址</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" readonly>
    
                                        </div>
                                    </div>
                                   
                                    
                                </form>
                            </div>

                            <div class="page-header">
                                <h3>參賽資料</h3> 
                            </div>
                            <div class="section-content">
                                <form  class="form-horizontal">
                                    <div class="form-group @if($errors->has('name')) has-error @endif">
                                        <div class="col-12 text-center">
                                         <h4 class="text-info"> @if($papers>0) 參賽次數 {{$papers}} 次 @else 你無參賽記錄，即刻<a href="{{ route('participant.participate') }}">參加比賽</a> @endif</h4>
                                        </div>
                                     </div>
                                    @if($user->participant)
                                    <div class="form-group @if($errors->has('name')) has-error @endif">
                                        <label for="name" class="col-sm-3 control-label" required>姓名</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->participant->name }}" readonly>
                                        
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('grade')) has-error @endif">
                                        <label for="grade" class="col-sm-3 control-label" required>年級</label>
                                        <div class="col-sm-9">
                                            <input type="grade" class="form-control" id="grade" name="grade"
                                                value="{{ $user->participant->grade }}" readonly>

                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if($errors->has('class')) has-error @endif">
                                        <label for="class" class="col-sm-3 control-label" required>班級</label>
                                        <div class="col-sm-9">
                                            <input type="class" class="form-control" id="class" name="class"
                                                value="{{ $user->participant->class }}" readonly>

                                        </div>
                                    </div>
                                    @endif


                                    <div class="form-group">
                                        
                                        <div class="col-sm-12 text-center">
                                            <a href="https://sso.quizfunz.com/user/profile" target="_blank"><div type="submit" class="btn btn-primary">更改資料</div></a>
                                            
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