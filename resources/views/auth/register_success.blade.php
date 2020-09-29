@extends('layouts.app')
    
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                @if(Agent::isMobile())
                    @include('home.comm.header')
                @endif

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <div class="message-container bg-white">
                            <div class="message-header text-center">
                                登記成功
                            </div>

                            <div class="message-content">
                                <p>您已成功登記！</p>
                                <p>驗證郵件已傳送至您的電郵信箱，請檢查郵件並完成驗證</p>
                            </div>

                            <div class="mesasge-footer text-center">
                                <a href="{{ route('home') }}" class="btn btn-primary">返回首頁</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
