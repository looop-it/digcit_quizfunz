@extends('layouts.app')

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
                    <div class="section-right">
                        <h2>比賽記錄</h2>
                        <div class="signup">
                            <form action="" method="post" onsubmit="return checkLength()" class="demoform">
                                <div class="from clearfix">
                                    @foreach($records as $season => $papers)
                                    <h3 style="text-align:left !important">{{ $season }}</h3>
                                    <div class="table table-responsive" style="width: 100%;
                                    padding: 0;
                                    margin: 0;">
                                        <table class="table table-responsive table-striped table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>參考編號</th>
                                                    <th>比賽得分</th>
                                                    <th>比賽使用時間 (秒)</th>
                                                    <th>比賽時間</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($papers as $paper)
                                                <tr>
                                                    <td>{{$paper->number}}</td>
                                                    <td>{{$paper->score}}</td>
                                                    <td>{{$paper->seconds_used}}</td>
                                                    <td>{{$paper->started_at}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                    @if (!$loop->last)
                                    <hr />
                                    @endif

                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                @include('home.comm.left_rank')
            </div>
        </div>
    </div>
</div>
@endsection