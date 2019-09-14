<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" class="next-head">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/fonts_api_josefin-sans-300-400-700.css') }}">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/fonts/ionicons/ionicons.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" href="/fonts/flaticon/flaticon.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('css/kn247/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kn247/style.css') }}">
    @yield('style')
</head>
<body id="body">
    <!-- START header -->
    @include('user.layouts.kn247.header')
    <!-- END header -->
    @include('user.layouts.kn247.slider', [
        'sliders' => $headers
    ])
    @yield('content')
    @include('user.layouts.kn247.footer')
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/user/index.js') }}" type="text/javascript"></script>
    @yield('script')
</body>
</html>