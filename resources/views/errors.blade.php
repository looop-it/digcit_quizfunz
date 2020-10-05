@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white" style="padding: 50px;">
                <span class="text-danger"><h2>錯誤</h2></span>

                <p>{{ $message }}</p>

                <p>&nbsp;</p>

                <p>如有任何查詢，請<a href="{{ route('enquiry') }}" target='_blank'>聯絡我們</a></p>
            </div>
        </div>
    </div>
</div>
@endsection