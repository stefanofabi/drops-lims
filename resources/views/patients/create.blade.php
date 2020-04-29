@extends('default-template')

@section('title')
{{ trans('patients.create_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/animals/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.create_animal') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/humans/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.create_human') }}</a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/industrials/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.create_industrial') }}</a>
	</li>
</ul>
@endsection


@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.create_patient') }}
@endsection

@section('content')
<div class="alert alert-info">
	<strong> {{ trans('forms.notice') }}! </strong> {{ trans('forms.select_for_continue') }}
</div>
@endsection

