@extends('administrators.default-template')

@section('title')
{{ trans('summaries.summaries') }}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/summaries/debt_social_works') }}"> {{ trans('summaries.debt_social_works') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/summaries/patient_flow') }}"> {{ trans('summaries.patient_flow') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/summaries/protocols_summary') }}"> {{ trans('summaries.protocols_summary') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-file-pdf"> </i> {{ trans('summaries.summaries') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('summaries.generate_summaries_message') }} 
</p>
@endsection

@section('content')
<p class="mt-3"> Select one of the menu options to continue </p>
@endsection
