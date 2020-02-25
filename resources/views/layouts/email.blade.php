<style>
    a {
        color: #007878;
    }

    a:hover {
        text-decoration: none;
    }

    table {
        font-family: 'Microsoft JhengHei', arial, sans-serif;
        font-size: 1rem;
        font-style: normal;
        font-weight: normal;
        width: 100%;
    }
</style>

<table cellpadding="0" cellspacing="0" style="font-family: 'Microsoft JhengHei', arial, sans-serif; font-size:1rem;font-style: normal; font-weight: normal; width: 100%; background-color: #f2f2f2; margin-bottom:20px;">
    <thead>
        <tr>
            <th style="background: skyblue; color: #FFF; padding:10px 20px;">
                <div style="margin:0 auto; width:100%; max-width:600px; padding:10px; -webkit-box-sizing:border-box; box-sizing:border-box;">
                    {{-- <a href="{{ config('app.url') }}" style="float:left;">
                        <img src="{{ config('app.url') }}/home/img/mobile_logo.png">
                        </div>
                    </a>
                    
                    @if (isset($title) && trim($title)!='') @endif --}}
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:40px; font-size:1rem; line-height: 1.4rem;">
                <div style="margin:0 auto; width:100%; max-width:600px; padding:20px; -webkit-box-sizing:border-box; box-sizing:border-box; border:1px solid #EAEAEA;">
                    <div>
                        @yield('content')
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
