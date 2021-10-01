@extends('layouts/app')

@section('title')
    {{ trans('home.dashboard') }}
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{ trans('home.dashboard') }} </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            @can('crud_patients')
                                <div class="col" style="text-align: center;">
                                    <a class="nav-link" style="color: black"
                                       href="{{ route('administrators/patients/index', ['type' => 'human', 'page' => 1]) }}">
                                        <h1>
                                            <i style="font-size: 8vw" class="fas fa-user-injured"></i>
                                        </h1>

                                        <br/>
                                        {{ trans('patients.patients') }}
                                    </a>
                                </div>
                            @endcan

                            @can('crud_determinations')
                                <div class="col" style="text-align: center;">
                                    <a class="nav-link" style="color: black"
                                       href="{{ route('administrators/determinations/index', ['page' => 1]) }}">
                                        <h1>
                                            <i style="font-size: 8vw" class="fas fa-syringe"></i>
                                        </h1>

                                        <br/>
                                        {{ trans('determinations.determinations') }}
                                    </a>
                                </div>
                            @endcan

                            @can('crud_protocols')
                                <div class="col" style="text-align: center;">
                                    <a class="nav-link" style="color: black"
                                       href="{{ route('administrators/protocols') }}">
                                        <h1>
                                            <i style="font-size: 8vw" class="fas fa-file-medical"></i>
                                        </h1>

                                        <br/>
                                        {{ trans('protocols.protocols') }}
                                    </a>
                                </div>

                            @endcan
                        </div>

                        <div class="row mt-3">
                            <div class="col">

                                @can('crud_prescribers')
                                    <div class="col" style="text-align: center;">
                                        <a class="nav-link" style="color: black"
                                           href="{{ route('administrators/prescribers/index', ['page' => 1]) }}">
                                            <h1>
                                                <i style="font-size: 8vw" class="fas fa-user-md"></i>
                                            </h1>

                                            <br/>
                                            {{ trans('prescribers.prescribers') }}
                                        </a>
                                    </div>
                                @endcan
                            </div>

                            @can('see_statistics')
                                <div class="col" style="text-align: center;">
                                    <a class="nav-link" style="color: black"
                                       href="{{ route('administrators/statistics') }}">
                                        <h1>
                                            <i style="font-size: 8vw" class="fas fa-chart-bar"></i>
                                        </h1>

                                        <br/>
                                        {{ trans('home.statistics') }}
                                    </a>
                                </div>
                            @endcan

                            @can('settings')
                                <div class="col" style="text-align: center;">
                                    <a class="nav-link" style="color: black" href="{{ route('administrators/settings/index') }}">
                                        <h1>
                                            <i style="font-size: 8vw" class="fas fa-cogs"></i>
                                        </h1>

                                        <br/>
                                        {{ trans('home.settings') }}
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
