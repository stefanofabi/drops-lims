@extends('administrators/patients/edit')

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('patients.patient_blocked') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/patients/store') }}">
	@csrf
    {{ method_field('PUT') }}

	<div class="col-10">
		<h4><i class="fas fa-book"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>

			<input type="text" class="form-control" name="full_name" value="{{ old('full_name') ?? $patient->full_name }}" required readonly>
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phone') }} </span>
				</div>
				<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ @old('phone') ?? $patient->phone }}" readonly>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_phone') }} </span>
				</div>
				<input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" value="{{ @old('alternative_phone') ?? $patient->alternative_phone }}" readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.email') }} </span>
				</div>
				<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ @old('email') ?? $patient->email }}" readonly>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_email') }} </span>
				</div>
				<input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" value="{{ @old('alternative_email') ?? $patient->alternative_email }}" readonly>
			</div>
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-id-card"></i> {{ trans('patients.tax_data') }} </h4>
			<hr class="col-6">
			
			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
				</div>
				
				<input type="text" class="form-control" name="business_name" value="{{ old('business_name') ?? $patient->business_name }}" readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.identification_number') }} </span>
				</div>

				<input type="number" class="form-control" name="identification_number" value="{{ old('identification_number') ?? $patient->identification_number }}" readonly>
			
                <div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>
				<select class="form-select input-sm" name="tax_condition_id" id="taxCondition" disabled>
					<option value=""> {{ trans('forms.select_option') }}</option>

					@foreach ($tax_conditions as $tax_condition)
					<option value="{{ $tax_condition->id }}"> {{ $tax_condition->name }} </option>
					@endforeach
				</select>
            </div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.fiscal_address') }} </span>
				</div>
				<input type="text" class="form-control" name="address" value="{{ old('address') ?? $patient->address }}" readonly>

				<div class="input-group-prepend">
						<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ old('city') ?? $patient->city }}" readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity" value="{{ old('start_activity') ?? $patient->start_activity }}" readonly>
			</div>
		</div>
	</div>

	<input type="submit" style="display: none" id="submit-button">
</form>
@endsection