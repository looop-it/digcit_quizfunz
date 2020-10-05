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
                            <div class="section-title mb-3">{{$page->name}}</div>

                            <div class="section-content">
                                {!!$page->content!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
