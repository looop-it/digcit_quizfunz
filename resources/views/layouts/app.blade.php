<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $global->website_name }}</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

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

        @include('footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" src="/home/js/common.js" charset="utf-8"></script>

    {{-- Mobile nav bar --}}
    <script type="text/javascript">
        $(document).ready(function () {
            var navBarSwiper = new Swiper.default('.mobile-nav-bar-container', {
                slidesPerView: 5,
                spaceBetween: 10,
                scrollbar: {
                    el: '.swiper-scrollbar',
                    hide: true,
                },
            });
        });
    </script>

    <script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>
    <script>
        var onloadCallback = function() {
            widgetId = grecaptcha.render('g-recaptcha', {
                'sitekey' : '{{ config('googlerecaptchav2.site_key') }}',
            });
        };
    </script>

    @include('common.ga')

    @yield('javascript')
</body>
</html>
