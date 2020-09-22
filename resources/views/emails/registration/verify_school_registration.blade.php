@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{$registration->name}}老師，您好！</p>

            <p>感謝 貴校支持「國安法、基本法通通識」全港中學網上挑戰賽，我們已收到 貴校提交的登記。</p>
            <p>請點擊以下連結完成登記驗證程序：</p>
            <p>
                <a href="{{ route('school.verify') }}?token={{$registration->verification_token}}" target="blank">
                    {{ route('school.verify') }}?token={{$registration->verification_token }}
                </a>
            </p>

            <p>&nbsp;</p>
            <p>如未能開啟以上鏈結，請複製網址並在瀏覽器開啟。</p>
            <p>&nbsp;</p>
            <p>
                如有任何查詢／更改資料，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank">聯絡我們，謝謝！</a>
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            QuizFunZ
        </td>
    </tr>
</table>
@endsection
