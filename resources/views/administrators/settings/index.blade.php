@extends('administrators/default-template')

@section('title')
{{ trans('settings.settings') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    From this section you can manage the different sections available for your laboratory and modify certain system configuration parameters.
</p>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/nomenclators/index') }}"> {{ trans('nomenclators.nomenclators') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/billing_periods/index') }}"> {{ trans('billing_periods.billing_periods') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('social_works.social_works') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-cogs"></i> {{ trans('settings.settings') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md mt-3">
        <div class="card">
            <div class="card-header"> Manage configs </div>

            <div class="card-body">
                <h5 class="card-title"> System parameters </h5>
                <p class="card-text"> Customize some sections by adjusting the available system parameters. </p>
                <a href="#" class="btn btn-primary @cannot('manage parameters') disabled @endcannot"> Edit parameters </a>
            </div>
        </div>
    </div>

    <div class="col-md mt-3">
        <div class="card">
            <div class="card-header"> Manage permissions </div>

            <div class="card-body">
                <h5 class="card-title"> Roles permissions </h5>
                <p class="card-text"> Define your strategy and control what actions each role can take in your lab while keeping security as the top priority. </p>
                <a href="#" class="btn btn-danger @cannot('manage roles') disabled @endcannot"> ⚠️ Go, i will be careful </a>
            </div>
        </div>
    </div>
</div>
@endsection
