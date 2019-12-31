<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')

        @include('navbar')

        @section('js')
        @show
        
    </head>

    <body>
        <div class="container-fluid">
            <!-- Column from menu-->
            <div class="card float-left margins-boxs-lr">
                <div class="card-header">
                    <h4> <i class="fas fa-home"></i> @section('menu-title') @show</h4>
                </div>

                <div class="card-body">
                        @section('menu')
                        @show
 
                </div>
            </div>

            <!-- Column from content -->
            <div class="card margins-boxs-tb">
                <div class="card-header">
                    <h4> <i class="fas fa-user"></i> @section('content-title') @show</h4>
                </div>

                <div class="card-body">
                    @section('content')
                    @show
                </div>
            </div>

        </div>
    </body>
</html>