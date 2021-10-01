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

	function submitForm() 
	{
		let submitButton = $('#submit-button');
        submitButton.click();

    }
</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'animal']) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('patients.create_animal') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'human']) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('patients.create_human') }}</a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'industrial']) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('patients.create_industrial') }}</a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.create_patient') }}
@endsection

@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary" onclick="submitForm()">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
@endsection