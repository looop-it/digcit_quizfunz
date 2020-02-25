@extends('layouts.app')

@section('style')
    <style type="text/css">
        .section{
            padding-top: 1px;
            min-height: 450px;

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

        .error-container {
            background: white;
            border:1px solid grey;
            border-radius: 5px;
            min-height: 200px;
            width: auto;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom:10px;

            font-size: 22px;
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
                        <div class="error-container">
                            @if(is_array($message)) 
                                @foreach ($message as $item)
                                    {!! $item !!}

                                    @if (!$loop->last)
                                        <br />
                                    @endif
                                @endforeach
                            @else
                                {!! $message !!}
                            @endif
                        </div>

                        <div class="text-center">
                            <p>
                                <a href="{{ route('home') }}" class="btn btn-primary">返回首頁</a>
                            </p>
                        </div>
                        
                    </div>
				</div>
			</div>
        </div>
    </div>
    <script type="text/javascript" src="/home/js/jquery-2.1.0.js"></script>
    
	@include('home.comm.foot')
    @include('home.comm.dialog')
    
    @if($global->total_number > 0)
        @include('home.comm.numRoll')
    @endif

@endsection
