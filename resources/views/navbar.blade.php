        <nav class="navbar navbar-expand-lg navbar-dark bg-info">
            <a class="navbar-brand" href="@yield('home-href')"> <img width="30" height="30" src="{{ asset('images/logo.png') }}"> </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @section('navbar_menu')
            @show
        </nav>