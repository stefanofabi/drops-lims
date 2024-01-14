<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title> @yield('title') - Drops</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <meta name="viewport" content="width=device-width, user-scalable=no">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Description that will be taken into account by web search engines  -->
        <meta name="description" content="Online results system designed for doctors who trust us with their patients"/>

        <!-- Keywords for better web positioning -->
        <meta name="keywords" content="laboratory, results, prescribers, online, patients, health, lims"/>

        <!-- Page authors -->
        <meta name="author" content="Stefano Fabi" />

        <!-- Copyright -->
        <meta name="copyright" content="Drops LIMS" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Used by ajax -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="module">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @section('navbar')
        @show

        @section('js')
        @show

        @section('css')
        @show
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow rounded-3 mt-3 ms-2 me-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset(Drops::getSystemParameterValueByKey('LOGO_IMAGE')) }}" width="104">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ trans('auth.register') }}</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </body>
</html>