@extends('default-filter')

@section('home-href')
{{ route('patients/home') }}
@endsection

@section('navbar_menu')
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link @yield('active_results')" href="{{ route('patients/results') }}"> {{ trans('home.results') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('active_family_members')" href="{{ route('patients/family_members/index') }}"> {{ trans('home.family_members') }}</a>
            </li>
        </ul>
    </div>
@endsection
