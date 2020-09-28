@extends('layouts.app')

@section('style')
<style>
    .section .section-right .loading {

        height: 52px;
    }
    
    .section .banner{
        margin-top: 14px;
    }
    .hot-content h4{ word-wrap:break-word; width:100%;}
    .rank-imgBox p{word-wrap:break-word; width:100%;}
    .section .section-right .hot-content > div > div:nth-child(2){overflow: visible;}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="section clearfix">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="section-middle section-idxmid">
						<div>
						@if(Agent::isMobile())
							@include('home.comm.header')
						@endif
						</div>
					</div>
				</div>
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-4">
                    <div class="section-right reference">
                        @if(!Agent::isMobile())
                            @include('home.advertisement.top-banner-desktop')
                        @endif
                        <div class="datum datum-re">
                            <h2>{{trans('home.main_menu.ref_info')}}</h2>
                            @if($references)
                                @foreach($references as $value)
                                    <div class="hot-content bgColor">
                                        <h4>
                                            @if($value->link)
                                                <a href="{{$value->link}}" target="_blank">
                                            @else
                                                <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                            @endif
                                                {{$value->name}}</a></h4>
                                        <div class="rank-imgBox clearfix">
                                            <div>
                                                @if($value->link)
                                                    <a href="{{$value->link}}" target="_blank">
                                                        @else
                                                            <a href="{{ route('references.detail', ['id' => $value->id]) }}">
                                                                @endif
                                                <img src="{{$img_url.$value->cover_image}}"/></a>
                                            </div>
                                            <div>
                                                <p>{{$value->desc}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="loading">
                                    {{$references->links('common.pagination')}}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>

@endsection
