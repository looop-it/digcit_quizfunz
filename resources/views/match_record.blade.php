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
                            <div class="section-title mb-3">我的成績</div>

                            <div class="section-content">
                                @if ($records && count($records) > 0)
                                    @foreach($records as $season => $papers)
                                    <h3>{{ $season }}</h3>

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

                                    @if (!$loop->last)
                                    <hr />
                                    @endif

                                    @endforeach
                                @else
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3>未有比賽紀錄</h3>
                                    </div>
                                </div>
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