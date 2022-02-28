<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')

        @section('navbar')
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
                
                    @include('messages')

                    @section('content')
                    @show
                </div>
            </div>
        </div>
    </body>
</html>
