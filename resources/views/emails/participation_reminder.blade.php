@extends('layouts.email')

@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <p><b>各位挑戰者：</b></p>

            <p>新一周《國安法、基本法通通識》全港中學線上挑戰賽已經開始，立即<a href="{{ route('login') }}">登入比賽</a>接受挑戰，贏取每周$200現金券之餘，同時為學校累積分數，爭取學校殊榮啦！</p>

            <p>恭喜上周成功挑戰的<a href="{{ route('ranking') }}" target="new">「最強知識王」</a>。</p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <br>
            <a href="{{ config('app.url') }}" target="blank">《國安法、基本法通通識》全港中學線上挑戰賽</a>
        </td>
    </tr>
</table>
@endsection
