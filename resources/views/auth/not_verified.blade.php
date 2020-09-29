@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-sm-12">
                            <div class="message-container bg-white">
                                <div class="message-header text-center">
                                    帳號還未啟動
                                </div>
    
                                <div class="message-content">
                                    <p>
                                        您的帳號還未啟動，請查看郵件依指示啟動您的帳號。
                                    </p>
            
                                    <p>
                                        或
                                    </p>
            
                                    <p>
                                        點擊以下按鈕，重新發送帳號啟動電郵。
                                    </p>
            
                                    <p>
                                        
                                    </p>
                                </div>
    
                                <div class="mesasge-footer text-center">
                                    <button id="resend" class="btn btn-main">
                                        重新發送
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 text-center">
                        
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
    $('#resend').click(function () {
            axios.post("{{ route('user.resend_verification_token') }}")
                .then(function (response) {
                    $('#resend').text('電郵已發送').attr('disabled', true);
                })
                .catch(function (error) {
                    console.log(error);
                    alert('發生錯誤，請稍後重試');
                })
        });
</script>
@endsection