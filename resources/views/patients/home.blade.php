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
                </div>

                <div class="row">
                    <div class="col">
                        <center>
                            <a class="nav-link" style="color: black" href="{{ route('patients/results') }}">
                                <h1>
                                    <i style="font-size: 8vw" class="fas fa-file-medical"></i>
                                </h1>

                                <br />
                                {{ trans('home.results') }}
                            </a>
                        </center>
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

            </div>
        </div>
    </div>
</div>
@endsection
