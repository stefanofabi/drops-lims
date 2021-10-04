@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	var enableForm = false;

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

		$("#submitButtonVisible").removeClass('disabled');

		enableForm = true;
	}

	function submitForm() 
	{
		if (enableForm) 
		{
			let submitButton = $('#submit-button');
            submitButton.click();
		}
    }
</script>
@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<p>
	<ul class="nav flex-column">
       @if(auth()->user()->can('crud_protocols'))
	        <li class="nav-item">
				<form action="{{ route('administrators/protocols/our/create') }}" id="create_protocol_form">
		        	@csrf
		            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
		        </form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('create_protocol_form').submit();"> 
					<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.create_protocol')}} 
				</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.view_protocols') }} </a>
			</li>
		@else 
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="alert('{{ trans('forms.no_permission') }}')"> 
					<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.create_protocol')}} 
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25" onclick="alert('{{ trans('forms.no_permission') }}')"> {{ trans('protocols.view_protocols') }} </a>
			</li>
		@endif

		@if(auth()->user()->can('generate_security_codes'))
			<li class="nav-item">
				<form id="security_code_form" target="_blank" action="{{ route('administrators/patients/security_codes/store') }}" method="post">
					@csrf
					<input type="hidden" name="patient_id" value="{{ $patient->id }}">
				</form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('security_code_form').submit();">
					<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('patients.get_security_code') }}
				</a>
			</li>
		@else
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="alert('{{ trans('forms.no_permission') }}')">
					<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('patients.get_security_code') }}
				</a>	
			</li>		
		@endif
	</ul>
</p>
@endsection


@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection

@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary disabled" onclick="submitForm()" id="submitButtonVisible">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
@endsection