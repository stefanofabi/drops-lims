<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')

        @include('navbar')

        @section('js')
        @show

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body> 
        <div class="container margins-boxs-tb">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group float-right">
                        <a  href="@yield('create-href', '#')" class="btn btn-info"><span class="fas fa-user-plus" ></span> @yield('create-text', 'Crear') </a>
                    </div>
                    <h4> <i class="fas fa-search"></i> @section('main-title') @show</h4>
                </div>

                <div class="card-body">
                    <div class="card">
                        <form method="post" id="select_page" action="{{ route('patients/load') }}">
                            @csrf
                            <div class="card-header">
                                <h5><i class="fas fa-filter"></i> Completar filtros</h5>
                            </div>

                            <div class="card-body">
                                @section('filters')
                                @show
                            </div>

                            <input type="hidden" id="page" name ="page" value="1">
                        </form>
                    </div>
                </div>

                @section('results')
                @show
                
            </div>
        </div>

        @section('footer')
        @show
    </body>
</html>