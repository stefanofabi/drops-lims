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
        <div class="col-md-3 mt-3 mb-3 float-start ps-1 pe-1">
            <h4> <i class="fas fa-home"></i> {{ trans('forms.menu') }} </h4>
            
            @section('menu')
            @show
        </div>

        <!-- Column from content -->
        <div class="col-md-9 mt-3 mb-3 float-end ps-1 pe-1">
            <div class="p-3 bg-primary text-white">
                <h1> @section('content-title') @show </h1>
                <p class="col-9"> Message </p>
            </div>
          
            @include('messages')

            @section('content')
            @show
        </div>
    </body>
</html>
