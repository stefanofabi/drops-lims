@extends('administrators/default-template')

@section('title')
{{ trans('statistics.statistics') }}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/annual_collection_social_work') }}"> {{ trans('statistics.annual_collection_social_work') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/patient_flow_per_month') }}"> {{ trans('statistics.patient_flow') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/track_income') }}"> {{ trans('statistics.track_income') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-chart-simple"></i> {{ trans('statistics.statistics') }}
@endsection

@section('content-message')
{{ trans('statistics.statistics_message') }}
@endsection

@section('content')
<p class="mt-3"> Select one of the menu options to continue </p>
@endsection
