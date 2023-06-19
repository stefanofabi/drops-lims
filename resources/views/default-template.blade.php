<!DOCTYPE html>
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
        
        <!-- SVG icons -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
    </head>

    <body class="bg-light">
        <div class="container-fluid">
            <div class="row">
                <!-- Column from menu-->
                <div class="col-md-3 mt-3">
                    @section('menu')
                    @show
                </div>

                <!-- Column from content -->
                <div class="col-md-9 mt-3 mb-3">
                    <div class="p-3 bg-primary text-white">
                        <h1> @section('content-title') @show </h1>
                        <p class="col-9 mt-3"> @section('content-message') &nbsp; @show </p>
                    </div>
                
                    @if(session('success'))
                    <div class="alert alert-success mt-3">
                        <p> <strong> {{ trans('forms.successful_transaction') }} </strong> </p>
                        
                        <ul>
                            @foreach (Session::get('success') as $message)
                            <li style="list-style:none;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                {{ $message }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <p> <strong> {{ trans('errors.error_processing_transaction') }} </strong> </p>

                        <ul>
                            @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @section('content')
                    @show
                </div>
            </div>
        </div>
    </body>
</html>
