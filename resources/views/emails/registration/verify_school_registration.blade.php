@extends('layouts.email')
@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{$school->contact}}，您好！</p>

            <p>多謝貴校支持大灣區知識爭霸戰－中學賽，請立即點擊以下連結完成註冊程序。</p>
            <p>點擊：<a href="{{ route('school.verify') }}?token={{$school->verification_token}}" target="blank">確認</a></p>

            <p>&nbsp;</p>
            <p>如未能開啟以上鏈結，請複製以下網址並在瀏覽器開啟。</p>
            <p>{{ route('school.verify') }}?token={{$school->verification_token}}</p>

            <p>&nbsp;</p>
            <p>
                如有任何查詢／更改資料，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank">聯絡我們，謝謝！</a>
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            圈傳媒 - LOOOP.HK
        </td>
    </tr>
</table>
@endsection
