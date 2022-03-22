@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a option from list
        $('#sex').val("{{ @old('sex') ?? $patient->sex }}");
		$('#taxCondition').val("{{ @old('tax_condition_id') ?? $patient->tax_condition_id }}");

		@if (sizeof($errors) > 0)
		enableSubmitForm();
		@endif
    });

	function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');

		$("#submitButton").removeAttr('disabled');
	}
</script>
@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection

@section('active_patients', 'active')

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
       @can('crud_protocols')
	        <li class="nav-item">
				<form action="{{ route('administrators/protocols/our/create') }}" id="create_protocol_form">
		            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
		        </form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('create_protocol_form').submit();"> {{ trans('protocols.create_protocol')}} </a>
			</li>
		@endcan

		@if(auth()->user()->can('generate_security_codes'))
			<li class="nav-item">
				<form id="security_code_form" target="_blank" action="{{ route('administrators/patients/security_codes/store') }}" method="post">
					@csrf
					<input type="hidden" name="patient_id" value="{{ $patient->id }}">
				</form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('security_code_form').submit();"> {{ trans('patients.get_security_code') }} </a>
			</li>
		@else
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="alert('{{ trans('forms.no_permission') }}')"> {{ trans('patients.get_security_code') }} </a>	
			</li>		
		@endif
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="mt-3 alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('patients.patient_blocked') }}
	</div>
@endif
@endsection
