@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $('#tax_condition').val("{{ $industrial['tax_condition'] ?? '' }}");
    });
</script>

@include('patients/phones/js')
@include('patients/emails/js')
@include('patients/social_works/affiliates/js')

@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
@include('patients/edit_menu')
@endsection

@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection

@section('content')

@include('patients/phones/edit')
@include('patients/emails/edit')
@include('patients/social_works/affiliates/edit')

<form method="post" action="{{ route('patients/update', $industrial->id) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="card mt-3">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> {{ trans('forms.complete_personal_data') }} </h4>
		</div>
		<div class="card-body">
			<div class="input-group mb-6 col-md-6">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
				</div>

				<input type="text" class="form-control" name="full_name" value="{{ $industrial->full_name }}" required>
			</div>
		</div>
	</div>

	<div class="card mt-3">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> {{ trans('forms.complete_fiscal_data') }} </h4>
		</div>

		<div class="card-body">
			<div class="input-group mb-6 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
				</div>
				<input type="text" class="form-control" name="business_name" value="{{ $industrial->business_name }}">
			</div>

			<div class="input-group mt-2 col-md-9">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
				</div>
				<input type="number" class="form-control" name="key" value="{{ $industrial->key }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>

				<select class="form-control input-sm" name="tax_condition" id="tax_condition">
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
				<input type="text" class="form-control" name="fiscal_address" value="{{ $industrial->fiscal_address }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ $industrial->city }}">
			</div>

			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity" value="{{ $industrial->start_activity }}">
			</div>

		</div>
	</div>


	<div class="card mt-3">
		<div class="card-header">
			<h4><i class="fas fa-book"></i> {{ trans('forms.complete_contact_information') }} </h4>
		</div>

		<div class="card-body">
			@include('patients/phones/index')

			@include('patients/emails/index')

		</div>
	</div>

	@include('patients/social_works/affiliates/index')

	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	

</form>
@endsection