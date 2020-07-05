@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ trans('home.dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <div style="text-align: center;">
                                <a class="nav-link" style="color: black" href="{{ route('patients/results') }}">
                                    <h1>
                                        <i style="font-size: 8vw" class="fas fa-file-medical"></i>
                                    </h1>

                                    <br />

                                    {{ trans('home.results') }}
                                </a>
                            </div>
                        </div>

                        <div class="col" style="text-align: center;">
                            <a class="nav-link" style="color: black" href="{{ route('administrators/determinations') }}">
                                <h1>
                                    <i style="font-size: 8vw" class="fas fa-ticket-alt"></i>
                                </h1>

                                <br />
                                {{ trans('home.reserve_shift') }}
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div style="text-align: center;">
                                <a class="nav-link" style="color: black" href="{{ route('patients/family_members/index') }}">
                                    <h1>
                                        <i style="font-size: 8vw" class="fas fa-users"></i>
                                    </h1>

                                    <br />

                                    {{ trans('home.family_members') }}
                                </a>
                            </div>
                        </div>

                        <div class="col">
                            <div style="text-align: center;">
                                <a class="nav-link" style="color: black" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <h1>
                                        <i style="font-size: 8vw" class="fas fa-sign-out-alt"></i>
                                    </h1>

                                    <br />

                                    {{ trans('auth.logout') }}

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
