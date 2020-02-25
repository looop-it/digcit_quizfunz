@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{ $school->contact }}老師，您好！</p>

            <p>貴校學生登入比賽的<b>學校認證碼</b>為：{{ $school->code }}</p>

            <p>學生需在比賽前完成以下程序:</p>

            <table>
                <tr>
                    <td>
                        <b>1. 登記成為挑戰者 </b><br />
                        已報名參賽學校的每位參賽學生需於比賽前於大會網站內登記成為挑戰者方可進入比賽系統；
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="{{ url('images/email/arrow_down.png') }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>2. 登入比賽系統 </b><br />
                        <ul>
                            <li>填寫補充資料 (如姓名、班級)</li>
                            <li>輸入<b>學校認證碼</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                            <img src="{{ url('images/email/arrow_down.png') }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>3. 開始比賽 </b>
                    </td>
                </tr>
            </table>
            <p>
                如有任何查詢，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank">聯絡我們</a>，謝謝！
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
