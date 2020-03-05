@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p>{{ $user->name }}，您好！</p>

            <p>多謝支持「歷史在線」挑戰賽！</p>

            <p>感謝閣下註冊成為挑戰者，請點擊以下連結啟動帳戶。</p>

            <p>
                <a href="{{ route('user.verify') }}?token={{$user->verification_token}}" target="new">
                    {{ route('user.verify') }}?token={{$user->verification_token}}
                </a>
            </p>
            
            <p>
                如有任何查詢，請<a href="{{ route('page.detail', ['slug' => '聯絡我們']) }}" target="blank">聯絡我們</a>
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            LOOOP.HK
        </td>
    </tr>
</table>
@endsection
