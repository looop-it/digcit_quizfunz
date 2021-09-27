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
                        <h2>個人資料</h2>
                        <div class="signup">
                            <form action="" method="post" onsubmit="return checkLength()" class="demoform">
                                <div class="from clearfix">
                                    <div style="width: 100%;">
                                        <label class="col-md-12 col-sm-12 col-xs-12">暱稱:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{$user->name}}" name="name"
                                                disabled="disabled" />
                                            <p></p>
                                        </div>

                                        <label class="col-md-12 col-sm-12 col-xs-12">通訊電郵:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="email" value="{{$user->email}}" disabled="disabled"
                                                style="overflow: hidden;" />
                                            <p></p>
                                        </div>

                                        <label class="col-md-12 col-sm-12 col-xs-12">聯絡電話:</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" value="{{$user->mobile}}" disabled="disabled" />
                                            <p></p>
                                        </div>
                                    </div>
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