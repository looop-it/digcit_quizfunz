@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white" style="padding: 50px;">
                <h2>登記完成</h2>

                <p>感謝 貴校支持「國安法、基本法通通識」全港中學線上挑戰賽！您的登記已完成。</p>
                <p>系統將寄出驗證郵件，請檢查電子郵箱（包括收件匣、垃圾郵箱及所有資料夾），並於48小時內點擊電郵內的驗證連結以完成登記程序。</p>

                <p>&nbsp;</p>

                <p>如有任何查詢，請<a href="{{ route('enquiry') }}" target='_blank'>聯絡我們</a></p>
            </div>
        </div>
    </div>
</div>
@endsection