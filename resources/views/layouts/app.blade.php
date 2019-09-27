<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/374c009c2f.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body data-spy="scroll" data-target="#side_nav">
    <div id="app" class="bg-dark">

        <nav class="fixed-top container-fluid nav-menu bg-dark p-2">
            <div class="nav-button flex-center">
                <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapse_nav_menu" aria-expanded="false" aria-controls="collapse_nav_menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="mr-auto" style="font-size: 20px;">
                    <span class="text-primary" id="page_position_mark"></span>
                    <span class="text-secondary" id="page_position_tag"></span>
                    <span class="text-light" id="page_position_category"></span>
                </div>
                <button class="btn btn-link text-light" type="button" data-toggle="collapse" data-target="#collapse_nav_more" aria-expanded="false" aria-controls="collapse_nav_more">
                    ?
                </button>
            </div>

            <div class="nav-collapsable bg-dark">
                <div class="collapse float-left" id="collapse_nav_menu">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                        <a class="nav-link {{ \Request::is('categories') ? 'active' : '' }}" href="{{ route('categories') }}">Categories</a>
                        <a class="nav-link {{ \Request::is('channels') ? 'active' : '' }}" href="{{ route('channels') }}">Channels</a>
                    </nav>
                </div>
                <div class="collapse float-right text-right" id="collapse_nav_more">
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('about') }}">About</a>

                        @guest
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                        @endguest
                        @auth
                        <a class="nav-link" href="{{ route("logout") }}">Logout</a>
                        @endauth
                        
                    </nav>
                </div>
            </div>

        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
