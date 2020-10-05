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
        @media (max-width: 1200px) and (min-width: 992px) {
            .section .section-middle > div .left-content div p:not(:nth-child(1))::after {
                width: 16px;
            }
        }

        @media (max-width: 992px) {
            .section .section-middle > div .left-content div p:not(:nth-child(1))::after {
                width: 23px;
            }
        }
		/*@media (min-width: 768px){
			.col-sm-push-5 {
				left: 38.666667%;
			}
			.col-sm-pull-8 {
				right: 66.666667%;
			}
		}*/

        a:link {
            text-decoration: none;
        }

        /* 	a:hover{color:red !important;}     */

        .section .section-middle > div .left-content {

            /* height: auto; */
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
								抱歉，您的帳號未能啟動。如有問題，請
								<a href="{{ route('enquiry') }}">聯絡我們</a>
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