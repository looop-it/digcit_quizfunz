@extends('layouts.email')
@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p><b>成功啟動！</b></p>

            <p>為增進教師對大灣區的了解，進而適切幫助學生認識大灣區，大會將於1月23日，下午四時至六時，舉辦「大灣區教師專業發展座談暨比賽簡介會」，邀請知名學者分享有關大灣區歷史、經濟、文化等方面與香港的關係及未來發展，並會介紹比賽，以及<b>派發<u>讀題攻略</u></b>和作進入系統之用的<b><u>學校認證碼</u></b>。每校<b>必須</b>派代表出席，詳情將以電郵通知，敬請密切留意。</p>

            <p>
                如有任何查詢／更改資料，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank">聯絡我們</a>，謝謝！
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
