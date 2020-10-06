@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    @include('left_panel')
                    
                    <div class="col-md-8 col-sm-12">
                        <div class="section-container">
                            <div class="section-title">活動詳情</div>

                            <div class="section-content ck-content">
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
                                                id="competition-child-{{$child->id}}" style="padding: 15px;">

                                                {!!$child->content!!}
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