@extends('layouts.email')
@section('content')
<table border="0" align="center" cellpadding="2" cellspacing="2" style="width:100%; font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left; word-break: break-all;">
    <tr>
        <td align="left" style="">
            <p><b>{{ strpos($registration->name, '老師') === false  ? $registration->name . "老師" : $registration->name}}：</b></p>

            <p>感謝 貴校支持 家國公民智多 FUN-全港中學生知識競賽 ，我們已核實 貴校的登記。</p>

            {{-- <p>您可以開始點擊以下連結，導入學生參賽名單：</p>

            <p>
                <a href="{{ route('student_account_import.index', ['token' => $token]) }}">
                    {{ route('student_account_import.index', ['token' => $token]) }}
                </a>
            </p>

            <p>
                如以上連結無法開啟，請手動到以下網址輸入資料：<br />

                網址：<a href="{{ route('student_account_import.index') }}" target="blank">{{ route('student_account_import.index') }}</a><br />
                電郵地址：{{ $registration->email }}<br />
                驗證碼：{{ $registration->school->code }}
            </p> --}}

            <p>
                如有任何查詢／更改資料，請<a href="{{ route('enquiry') }}" target="blank">聯絡我們</a>
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
