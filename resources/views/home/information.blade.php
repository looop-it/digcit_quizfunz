<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{trans('home.main_menu.game_intro')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    {{-- Common CSS --}}
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/style.css"/>
    <style>
        .section .section-right img {
            position: static !important;
        }
        .section .section-right .middle-match .match-title ul {
            text-align: left;
        }

        .section .section-right .middle-match .match-title ul li:not(:nth-child(100)) {
            margin-right: 3%;
        }

        @media (max-width: 1200px) {
            .section .section-right .middle-match .match-title ul li:not(:nth-child(100)) {
                margin-right: 2%;
            }
        }
        .match-content img{width:100%!important;}
        .match-content{ word-wrap:break-word; width:100%;}

        .nav-tabs > li.active > a {
            color: #000000 !important;
            background-color: #fff46d !important;
        }

        /* .nav-tabs.child > li.active > a {
            color: white !important;
            background-color: green !important;
        } */
    </style>
</head>
<body>
@php($nav=2)
@include('home.comm.head')
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
                    <div class="section-right">
                        <h2>{{trans('home.main_menu.game_intro')}}</h2>

                        <p>&nbsp;</p>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($competitions as $competition)
                                <li role="presentation" class="@if($loop->first) active @endif">
                                    <a href="#competition-{{$competition->id}}" aria-controls="competition-{{$competition->id}}" role="tab" data-toggle="tab">{{ $competition->title }}</a>
                                </li>
                            @endforeach
                        </ul>
    
                        <!-- Tab panes -->
                        <div class="tab-content" style="margin: 0 !important;">
                            @foreach ($competitions as $competition)
                                <div role="tabpanel" class="tab-pane @if($loop->first) active @endif" id="competition-{{$competition->id}}">
                                    <p>&nbsp;</p>

                                    <ul class="nav nav-tabs child" role="tablist">
                                        @foreach($competition->children as $child)
                                            <li role="presentation" class="@if($loop->first) active @endif">
                                                <a href="#competition-child-{{$child->id}}" aria-controls="competition-child-{{$child->id}}" role="tab" data-toggle="tab">{{ $child->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content" >
                                        @foreach($competition->children as $child)
                                            <div role="tabpanel" class="tab-pane @if($loop->first) active @endif" id="competition-child-{{$child->id}}">
                                                <p>&nbsp;</p>

                                                <ul>
                                                    {!!$child->content!!}
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@include('home.comm.foot')

{{-- Common Js --}}
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script src="/home/js/idangerous.swiper2.7.6.min.js" type="text/javascript" charset="utf-8"></script>
@if($global->total_number > 0)
    @include('home.comm.numRoll')
@endif
<script src="/home/js/overfloat.js" type="text/javascript" charset="utf-8"></script>
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>




</body>
</html>
