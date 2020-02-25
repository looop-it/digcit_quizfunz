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
                                你已成功啟動帳號，請密切留意比賽網站，關注比賽最新消息。
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
	<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/home/js/overfloat.js"></script>
	<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
@endsection