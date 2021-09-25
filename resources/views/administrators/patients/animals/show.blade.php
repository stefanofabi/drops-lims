@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $('#sex').val('{{ $patient->sex }}');
    });
</script>
@endsection

@section('title')
{{ trans('patients.show_patient') }}
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
				<form id="create_protocol_form" action="{{ route('administrators/protocols/our/create') }}" method="post">
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
<i class="fas fa-user-shield"></i> {{ trans('patients.show_patient') }}
@endsection


@section('content')

<div class="alert alert-info fade show">
	<a href="{{ route('administrators/patients/edit', $patient->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('forms.personal_data') }} </h4>
	</div>

	<div class="card-body">

		<strong> {{ trans('patients.owner_data') }} </strong>
		<div class="input-group mt-2 col-md-9">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.owner') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->owner }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.dni') }} </span>
			</div>
			<input type="number" class="form-control" value="{{ $patient->key }}" disabled>
		</div>

		<div class="input-group mt-2 mb-4 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->address }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->city }}" disabled>
		</div>

		<strong> {{ trans('patients.animal_data') }} </strong>
		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->full_name }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-select input-sm" id="sex" disabled>
				<option value=""> {{ trans('patients.select_sex') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>


		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control" value="{{ $patient->birth_date }}" disabled>
		</div>

	</div>
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
	</div>

	<div class="card-body">

		@include('administrators/patients/phones/show')
		@include('administrators/patients/emails/show')

	</div>
</div>

@include('administrators/patients/social_works/affiliates/show')

@endsection
