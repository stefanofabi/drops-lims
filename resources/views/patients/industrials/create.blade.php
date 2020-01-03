@extends('patients/create')

@section('content')
<form method="post" action="{{ route('patients/industrials/store') }}">
	@csrf

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> {{ trans('patients.complete_personal_data') }} </h4>
		</div>
		<div class="card-body">
			<div class="input-group mb-6 col-md-6">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>

				<input type="text" class="form-control" name="name" required>
			</div>
		</div>
	</div>

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> {{ trans('patients.complete_fiscal_data') }} </h4>
		</div>

		<div class="card-body">
			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
				</div>
				<input type="text" class="form-control" name="business_name">
			</div>

			<div class="input-group mb-10 col-md-10" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
				</div>
				<input type="number" class="form-control" name="cuit">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>
				<select class="form-control input-sm" name="tax_condition">
					<option value=""> {{ trans('patients.select_condition') }}</option>
					@foreach ($conditions as $condition)
					<option value="{{ $condition->name}}"> {{ $condition->name }} </option>
					@endforeach
				</select>
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.fiscal_address') }} </span>
				</div>
				<input type="text" class="form-control" name="fiscal_address">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city">
			</div>

			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity">
			</div>

		</div>
	</div>


	<div class="float-right">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('patients.save') }}
		</button>
	</div>	
</form>
@endsection