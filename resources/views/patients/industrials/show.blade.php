@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $('#tax_condition').val("{{ $industrial['tax_condition'] ?? '' }}");
    });
</script>
@endsection

@section('title')
{{ trans('patients.show_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Crear protocolo </a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Ver protocolos</a>
		</li>
	</ul>
</p>
@endsection

@section('content-title')
<i class="fas fa-user-shield"></i> {{ trans('patients.show_patient') }}
@endsection

@section('content')
<div class="alert alert-info fade show">
	<a href="{{ route('patients/edit', [$industrial['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-toolbox"></i> {{ trans('forms.personal_data') }} </h4>
	</div>
	<div class="card-body">
		<div class="input-group mt-2 col-md-9">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>

			<input type="text" class="form-control" value="{{ $industrial->full_name }}" disabled>
		</div>
	</div>
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('forms.complete_fiscal_data') }} </h4>
	</div>

	<div class="card-body">
		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial->business_name }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
			</div>
			<input type="number" class="form-control" value="{{ $industrial->key }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
			</div>

			<select class="form-control input-sm" id="tax_condition" disabled>
				<option value=""> {{ trans('patients.select_condition') }} </option>
				<option value="Exempt"> {{ trans('patients.exempt') }} </option>
				<option value="Monotax"> {{ trans('patients.monotax') }} </option>
				<option value="Not responsible"> {{ trans('patients.not_responsible') }} </option>
				<option value="Registered Responsible"> {{ trans('patients.registered_responsible') }} </option>
			</select>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.fiscal_address') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial->address }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial->city }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
			</div>

			<input type="date" class="form-control" value="{{ $industrial->start_activity }}" disabled>
		</div>

	</div>
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
	</div>

	<div class="card-body">

		@include('patients/phones/show')
		@include('patients/emails/show')

	</div>
</div>

@include('patients/social_works/affiliates/show')


@endsection