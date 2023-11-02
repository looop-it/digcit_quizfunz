@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>感謝登記，惟  閣下的登記資料有誤，如  閣下是學校的任科老師，煩請與我們聯絡；如  閣下是參賽學生，請至 QUIZFUNZ 網站完成登記程序：https://quizfunz.com</p>

            <p>
                如有任何查詢，請<a href="{{ route('enquiry') }}" target="blank">聯絡我們</a>
            </p>

        </td>
    </tr>
</table>
@endsection
