@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{ $school->contact }}老師，您好！</p>

            <p>截止今早8時， 貴校學生作賽報告如下。</p>

            <p>
                全校人數：{{ $school->student }} (以學校登記時提交的人數為參考)<br />
                {{-- 預計參加人數：{{ $school->expected_participant }}<br /> --}}
                已作賽人數：{{ $school->statistics()->first()->participants ? $school->statistics()->first()->participants : 0 }}<br />
                {{-- 貴校參與率：{{ round($school->actual_participant / $school->student * 100, 2) }}% --}}
            </p>
            <p>
                隨電郵附上已報名學生詳細資料，歡迎查閱。如有任何查詢，請<a href="{{ route('enquiry') }}" target="blank">聯絡我們</a>，謝謝！
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            青識教育發展中心
        </td>
    </tr>
</table>
@endsection
