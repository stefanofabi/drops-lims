@extends('administrators/default-template')

@section('title')
{{ trans('statistics.statistics') }}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/collection_social_work/index') }}"> {{ trans('statistics.collection_social_work') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/patient_flow/index') }}"> {{ trans('statistics.patient_flow') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/track_income/index') }}"> {{ trans('statistics.track_income') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/social_work_composition/index') }}"> {{ trans('statistics.social_work_composition') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/statistics/sex_composition/index') }}"> {{ trans('statistics.sex_composition') }} </a>
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
