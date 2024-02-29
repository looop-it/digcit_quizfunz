@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{ $r->name }}老師，您好！</p>

            <p>貴校學生登入 家國公民智多 FUN 全港中學生知識競賽 -「校際賽」的學校認證碼為<br>
                <h1>{{ $r->school->code }}</h1></p>

            <p>學生需在比賽前完成以下程序:</p>

            <table>
                <tr>
                    <td>
                        <b>1. 登記成為挑戰者 </b><br />
                        已報名參賽學校的每位參賽學生需於比賽前於大會網站內登記成為挑戰者；
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>2. 登入比賽系統 </b><br />
                        <ul>
                            <li>學生需要在個人資料選擇正確的個人和學校信息(如姓名、班級)</li>
                            <li>學生在開始比賽頁面需要輸入正確的<b>學校認證碼</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>3. 開始比賽 </b>
                    </td>
                </tr>
            </table>
            <p>
                如有任何查詢，請<a href="{{ route('enquiry') }}" target="blank">聯絡我們</a>，謝謝！
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            Regards,
            <br>
            QUIZFUNZ 智多分
        </td>
    </tr>
</table>
@endsection
