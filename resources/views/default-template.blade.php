<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title> @yield('title') - Drops</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <meta name="viewport" content="width=device-width, user-scalable=no">

        <!-- Laravel mix -->
        <script src="{{ asset('js/app.js') }}"></script>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Description that will be taken into account by web search engines  -->
        <meta name="description" content="Online results system designed for doctors who trust us with their patients"/>

        <!-- Keywords for better web positioning -->
        <meta name="keywords" content="laboratory, results, prescribers, online, patients, health, lims"/>

        <!-- Page authors -->
        <meta name="author" content="Stefano Fabi" />

        <!-- Copyright -->
        <meta name="copyright" content="SrLab" />

        <!-- Used by ajax -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @section('navbar')
        @show

        @section('css')
        <style>
            @media (max-width: 768px) {
                .verticalButtons {
                    margin-top: 5px;
                }
            }
        </style>
        @show

        @section('js')
        @show
    </head>

    <body class="bg-light">
        <!-- Column from menu-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 mt-3">
                    <h4> <i class="fas fa-home"></i> {{ trans('forms.menu') }} </h4>
                    
                    @section('menu')
                    @show
                </div>

                <!-- Column from content -->
                <div class="col-md-9 mt-3">
                    <div class="p-3 bg-primary text-white">
                        <h1> @section('content-title') @show </h1>
                        <p class="col-9"> Message </p>
                    </div>
                
                    @if(isset($success) && count($success) > 0)
                    <div class="alert alert-success mt-3">
                        <p> <strong> {{ trans('forms.successful_transaction') }} </strong> </p>
                        
                        <ul>
                            @foreach ($success as $message)
                            <li>{{ $message }}</li>
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
