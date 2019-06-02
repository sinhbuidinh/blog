<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/fonts_api_josefin-sans-300-400-700.css') }}">

    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">

    <link rel="stylesheet" href="/fonts/ionicons/ionicons.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" href="/fonts/flaticon/flaticon.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/css/style.css">
    @yield('style')
</head>
<body>
    <!-- START section -->
    @include('user.layouts.header')
    <!-- END header -->

    @if(!isset($without_slider))
    <!-- START section -->
    @include('user.layouts.slider', [
        'have_suggest' => isset($have_suggest) ? $have_suggest : false
    ])
    <!-- END section -->
    @endif

    @yield('content')

    <!-- START footer -->
    @include('user.layouts.footer')
    <!-- END footer -->

    <!-- START loader -->
    @include('user.layouts.loader')
    <!-- END loader -->

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/jquery-migrate-3.0.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/jquery.waypoints.min.js"></script>
    <script src="/js/jquery.stellar.min.js"></script>

    <script src="/js/main.js"></script>
    @yield('script')
</body>
</html>