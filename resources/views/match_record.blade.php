@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    @include('user_left_panel')

                    <div class="col-md-8 col-sm-12">
                        <div class="section-container">
                            <div class="page-header">
                                <h3>參賽記錄</h3>
                            </div>

                            <div class="section-content">
                                @if ($records && count($records) > 0)
                                    @foreach($records as $season => $papers)
                                    <h3>{{ $season }}</h3>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>參考編號</th>
                                                    <th>比賽得分</th>
                                                    <th>比賽用間 (秒)</th>
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