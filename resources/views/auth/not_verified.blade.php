@extends('layouts.app')

@section('style')
    <style type="text/css">
        .section{
            padding-top: 1px;
            min-height: 450px;
            font-size: 25px;

            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .section .section-middle > div .left-content div p:not(:nth-child(1))::after {
            width: 13px;
        }

		.section .section-middle > div > div:nth-child(2) {
			padding: 0 13px 0 18px;
		}
		
		.section .section-top{
			margin: 0;
		}

        a:link {
            text-decoration: none;
        }
	</style>
@endsection

@section('content')
	@include('home.comm.head')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="section section-idx">
					<div class="section-middle clearfix">
						<div class="row">
							<div class="col-md-12 col-sm-12 text-center">
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
                                    <button id="resend" class="btn btn-primary">
                                        重新發送
                                    </button>
                                </p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('home.comm.foot')
	@include('home.comm.dialog')
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