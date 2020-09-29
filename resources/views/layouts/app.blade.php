<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$global->website_name}}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>

    @yield('style')
</head>

<body>
    <div id="app">
        @include('header')

        @yield('content')

        @include('home.comm.dialog')
        @include('footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" src="/home/js/common.js" charset="utf-8"></script>
    <script type="text/javascript" src="/home/js/overfloat.js"></script>

    @yield('javascript')

    @include('common.ga')
</body>
</html>
