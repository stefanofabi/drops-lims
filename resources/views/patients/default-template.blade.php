@extends('default-template')

@section('navbar_menu')
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link @yield('active_dashboard')" href="{{ route('patients/home') }}"> {{ trans('home.dashboard') }} </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('active_results')" href="{{ route('patients/results') }}"> {{ trans('home.results') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('active_family_members')" href="{{ route('patients/family_members/index') }}"> {{ trans('home.family_members') }}</a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            </li>
        </ul>
    </div>
@endsection
