@extends('patients/create')

@section('content')
<form method="post" action="{{ route('patients/store') }}">
	@csrf

	<input type="hidden" name="type" value="industrial">

	<div class="card mt-3">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> {{ trans('forms.complete_personal_data') }} </h4>
		</div>
		<div class="card-body">
			<div class="input-group mt-2 col-md-9">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
				</div>

				<input type="text" class="form-control" name="full_name" required>
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
				<input type="text" class="form-control" name="business_name">
			</div>

			<div class="input-group mt-2 col-md-9">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
				</div>
				<input type="number" class="form-control" name="key">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>
				<select class="form-control input-sm" name="tax_condition">
					<option value=""> {{ trans('forms.select_option') }}</option>
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
				<input type="text" class="form-control" name="fiscal_address">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city">
			</div>

			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity">
			</div>

		</div>
	</div>


	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection