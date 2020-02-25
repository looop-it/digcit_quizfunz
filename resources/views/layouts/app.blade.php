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
    <script src="{{ asset('js/manifest.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/home/css/swiper-2.7.6.min.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/home/css/hot.css"/>

    @yield('style')
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @include('common.ga')
    
    @yield('javascript')
</body>
</html>
