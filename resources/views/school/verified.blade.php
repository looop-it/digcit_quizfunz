@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white" style="padding: 50px;">
                <span class="text-success"><h2>完成登記驗證</h2></span>

                <p>恭喜您!已完成登記驗證，請密切留意比賽資訊。</p>

                <p>&nbsp;</p>

                <p>如有任何查詢，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target='_blank'>聯絡我們</a></p>
            </div>
        </div>
    </div>
</div>
@endsection