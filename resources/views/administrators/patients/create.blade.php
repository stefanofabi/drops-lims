@extends('administrators/default-template')

@section('title')
{{ trans('patients.create_patient') }}
@endsection

@section('active_patients', 'active')

@section('js')
<script type="text/javascript">
	var enableForm = false;

	$(document).ready(function() 
	{
        // Select a option from list
        $('#sex').val("{{ @old('sex') }}");
		$('#taxCondition').val("{{ @old('tax_condition_id') }}");
    });
</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'animal']) }}"> {{ trans('patients.create_animal') }} </a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'human']) }}"> {{ trans('patients.create_human') }}</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'industrial']) }}"> {{ trans('patients.create_industrial') }}</a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.create_patient') }}
@endsection