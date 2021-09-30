@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="content-container">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
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
                            <div class="section-title mb-3">參賽資料</div>

                            <div class="text-center" style="padding:5px;">
                                開始比賽前，請先<a href="{{ config('quiz.profile_edit_url') }}" target="_blank">按此</a>完善參賽資料
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // check the visiblility of the page
    window.onload = function() {
        var hidden, visibilityState, visibilityChange;

        if (typeof document.hidden !== "undefined") {
            hidden = "hidden", visibilityChange = "visibilitychange", visibilityState = "visibilityState";
        }
        else if (typeof document.mozHidden !== "undefined") {
            hidden = "mozHidden", visibilityChange = "mozvisibilitychange", visibilityState = "mozVisibilityState";
        }
        else if (typeof document.msHidden !== "undefined") {
            hidden = "msHidden", visibilityChange = "msvisibilitychange", visibilityState = "msVisibilityState";
        }
        else if (typeof document.webkitHidden !== "undefined") {
            hidden = "webkitHidden", visibilityChange = "webkitvisibilitychange", visibilityState = "webkitVisibilityState";
        }

        if (typeof document.addEventListener === "undefined" || typeof hidden === "undefined") {
            // not supported
        }
        else {
            document.addEventListener(visibilityChange, function() {
                switch (document[visibilityState]) {
                case "visible":
                    // visible

                    location.reload();
                    break;
                case "hidden":
                    // hidden
                    break;
                }
            }, false);
        }
    };
</script>
@endsection