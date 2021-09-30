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

<form method="post" action="{{ route('administrators/patients/update', $patient->id) }}">
	@csrf
    {{ method_field('PUT') }}

	<div class="col-10">
		<h4><i class="fas fa-book"></i> {{ trans('patients.animal_data') }} </h4>
		<hr class="col-6">
		
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>
			<input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ @old('full_name') ?? $patient->full_name }}" required readonly>
		</div>
		
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-select input-sm @error('sex') is-invalid @enderror" name="sex" id="sex" required disabled>
				<option value=""> {{ trans('forms.select_option') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>
				
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ @old('birth_date') ?? $patient->birth_date }}" readonly>
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-book"></i> {{ trans('patients.owner_data') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.owner') }} </span>
				</div>

				<input type="text" class="form-control @error('owner') is-invalid @enderror" name="owner" value="{{ @old('owner') ?? $patient->owner }}" required readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.dni') }} </span>
				</div>

				<input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ @old('identification_number') ?? $patient->identification_number }}" readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ @old('address') ?? $patient->address }}" readonly>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ @old('city') ?? $patient->city }}" readonly>
			</div>
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
	</div>

	<input type="submit" style="display: none"  id ="submit-button">
</form>
@endsection