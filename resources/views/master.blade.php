<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="Robots" content="noindex,nofollow">

        <title>Battlenet - Diablo3</title>

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery.loading.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
        <link href="{{ asset('css/d3.css') }}" rel="stylesheet">

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery.loading.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script src="{{ asset('js/d3.js') }}"></script>

    </head>
    <body id="page-top">
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113477163-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-113477163-1');
        </script>
        <nav class="text-uppercase">
            <div class="nav-container">
                <a href="{{ route('home') }}" class="logo">Diablo3</a>
                <button class="btn btn-default dropdown-toggle-menu" type="button">Menu
                <span class="glyphicon glyphicon-menu-hamburger"></span></button>
                <div class="navbar-side">
                    <ul class="navbar-side-menu pointer">
                    <li url="{{ route('home') }}">Profile</li>
                    <li url="{{ route('weapon') }}">calculator</li>
                    @php
                        $seasonIndex = Util::getIndex('current_season');
                    @endphp
                    <li url="/rank/kr/season/{{ $seasonIndex }}/barbarian">rank</li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        @include('sweet::alert')
    </body>
</html>