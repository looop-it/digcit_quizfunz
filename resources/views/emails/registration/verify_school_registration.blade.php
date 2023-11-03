@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p><b>{{ strpos($registration->name, '老師') === false  ? $registration->name . "老師" : $registration->name}}：</b></p>

            <p>感謝 貴校支持 家國公民智多 FUN-全港中學生知識競賽，我們已收到 貴校提交的登記。</p>
            <p>請點擊以下連結完成登記驗證程序：</p>
            <p>
                <a href="{{ route('school_registration.verify') }}?token={{$registration->verification_token}}" target="blank">
                    {{ route('school_registration.verify') }}?token={{$registration->verification_token }}
                </a>
            </p>

            <p>&nbsp;</p>
            <p>如未能開啟以上鏈結，請複製網址並在瀏覽器開啟。</p>
            <p>&nbsp;</p>
            {{-- <p>完成驗證後，老師可提供學生名單* ，發送至 project@shinetak.org.hk。系統會發出參賽邀請；老師亦可自行呼籲學生登記參賽。</p>
            <p>*名單範本請參閱：<a href="https://nse3.quizfunz.com/news/2">https://nse3.quizfunz.com/news/2</a></p> --}}
            <p>&nbsp;</p>
            <p>
                如有任何查詢／更改資料，請<a href="{{ route('enquiry') }}" target="blank">聯絡我們</a>，謝謝！
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            <a href="{{ config('app.url') }}" target="blank">QuizFunZ</a>
        </td>
    </tr>
</table>
@endsection
