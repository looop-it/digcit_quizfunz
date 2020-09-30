@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
					@include('left_panel', ['showReference' => false])

                    <div class="col-md-8 col-sm-12">
						<div class="section-container">
                            <div class="section-title mb-3">參考資料</div>

                            <div class="section-content">
                                @if($references)
                                    @foreach($references as $reference)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        @if($reference->link)
                                                        <a href="{{ $reference->link }}" target="_blank"><strong>{{ $reference->name }}</strong></a>
                                                        @else
                                                        <a href="{{ route('references.detail', ['id' => $reference->id]) }}"><strong>{{ $reference->name }}</strong></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        @if($reference->cover_image)
                                                        <a href="{{ route('references.detail', ['id' =>$reference->id]) }}">
                                                            <img src="{{$img_url.$reference->cover_image}}" class="img-fluid" />
                                                        </a>
                                                        @else
                                                            <img src="/home/img/default-post-cover.jpg" class="img-fluid">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="excerpt mb-3">
                                                            <p>{{ $reference->desc }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    @endforeach
                                @endif
                            </div>
						</div>
					</div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
