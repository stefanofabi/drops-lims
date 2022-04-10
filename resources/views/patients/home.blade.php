@extends('layouts.app')

@section('title')
{{ trans('home.dashboard') }}
@endsection

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
                                <a class="nav-link" style="color: black" href="{{ route('patients/protocols/index') }}">
                                    <h1>
                                        <i style="font-size: 8vw" class="fas fa-file-medical"></i>
                                    </h1>

                                    <br />

                                    {{ trans('protocols.protocols') }}
                                </a>
                            </div>
                        </div>

                        <div class="col" style="text-align: center;">
                            <a class="nav-link" style="color: black" href="#">
                                <h1>
                                    <i style="font-size: 8vw" class="fas fa-ticket-alt"></i>
                                </h1>

                                <br />
                                {{ trans('patients.reserve_shift') }}
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

                                    {{ trans('patients.family_members') }}
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
