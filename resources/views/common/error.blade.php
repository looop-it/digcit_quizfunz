@extends('layouts.app')

@section('style')
<style>
    .message-container .message-header {
        background: #fdb93b;
        color: #272959 !important;
    }

    .message-container .btn-primary {
        color: #272959;
        background-color: #fdb93b;
        border-color: #fdb93b;
    }

    .message-container .btn-primary:hover,
    .message-container .btn-primary:focus,
    .message-container .btn-primary:active {
        color: #272959;
        background-color: #fd8b2f;
        border-color: #fd8b2f;
    }
</style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="content-container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-sm-12">
                            <div class="message-container bg-white">
                                <div class="message-header text-center">
                                    發生錯誤！
                                </div>
    
                                <div class="message-content text-center">
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
