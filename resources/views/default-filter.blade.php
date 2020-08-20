<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')

        @include('navbar')

        @section('js')
        @show

    </head>

    <body>
        <div class="container mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group float-right">
                        <a  href="@yield('create-href', '#')" class="btn btn-info"> @yield('create-text') </a>
                    </div>
                    <h4> @section('main-title') @show </h4>
                </div>

                @section('card-filters')
                <div class="card-body">

                    @section('messages')
                    @show
                    
                    <div class="card">
                        <form method="post" id="select_page" action="@yield('action_page')">
                            @csrf
                            <div class="card-header">
                                <h5><i class="fas fa-filter"></i> {{ trans('forms.complete_filters') }} </h5>
                            </div>

                            <div class="card-body">
                                @section('filters')
                                @show
                            </div>

                            <input type="hidden" id="page" name ="page" value="1">
                        </form>
                    </div>
                </div>
                @show

                @section('results')
                @show

            </div>
        </div>

        @section('footer')
        @show
    </body>
</html>
