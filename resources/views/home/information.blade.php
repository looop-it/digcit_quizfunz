@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        @if (! Agent::isMobile())
                        <div class="row mb-3">
                            <div class="col-xs-12">
                                @include('home.comm.latest_news')
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-xs-12">
                                @include('home.comm.referenceMaterial')
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-12">
                        <div class="section-container">
                            <div class="section-title">活動詳情</div>

                            <div class="section-content">
                                <!-- Nav tabs -->
                                {{-- <ul class="nav nav-tabs" role="tablist">
                                    @foreach ($competitions as $competition)
                                    <li role="presentation" class="@if($loop->first) active @endif">
                                        <a href="#competition-{{$competition->id}}"
                                            aria-controls="competition-{{$competition->id}}" role="tab"
                                            data-toggle="tab">{{ $competition->title }}</a>
                                    </li>
                                    @endforeach
                                </ul> --}}

                                <!-- Tab panes -->
                                <div class="tab-content" style="margin: 0 !important;">
                                    @foreach ($competitions as $competition)
                                    <div role="tabpanel" class="tab-pane @if($loop->first) active @endif"
                                        id="competition-{{$competition->id}}">
                                        <p>&nbsp;</p>

                                        <ul class="nav nav-tabs child" role="tablist">
                                            @foreach($competition->children as $child)
                                            <li role="presentation" class="@if($loop->first) active @endif">
                                                <a href="#competition-child-{{$child->id}}"
                                                    aria-controls="competition-child-{{$child->id}}" role="tab"
                                                    data-toggle="tab">{{ $child->title }}</a>
                                            </li>
                                            @endforeach
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            @foreach($competition->children as $child)
                                            <div role="tabpanel" class="tab-pane @if($loop->first) active @endif"
                                                id="competition-child-{{$child->id}}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection