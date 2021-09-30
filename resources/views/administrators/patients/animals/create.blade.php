@extends('administrators/patients/create')

@section('content')
<form method="post" action="{{ route('administrators/patients/store') }}">
	@csrf

	<input type="hidden" name="type" value="animal">
 
	<div class="col-10">
		<h4><i class="fas fa-book"></i> {{ trans('patients.animal_data') }} </h4>
		<hr class="col-6">
		
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>
			<input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ @old('full_name') }}" required>
		</div>
		
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-select input-sm @error('sex') is-invalid @enderror" name="sex" id="sex" required>
				<option value=""> {{ trans('forms.select_option') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>
				
		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ @old('birth_date') }}">
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-book"></i> {{ trans('patients.owner_data') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.owner') }} </span>
				</div>

				<input type="text" class="form-control @error('owner') is-invalid @enderror" name="owner" value="{{ @old('owner') }}" required>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.dni') }} </span>
				</div>

				<input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number"  value="{{ @old('identification_number') }}">
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ @old('address') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ @old('city') }}">
			</div>
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phone') }} </span>
				</div>
				<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ @old('phone') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_phone') }} </span>
				</div>
				<input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" value="{{ @old('alternative_phone') }}">
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.email') }} </span>
				</div>
				<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ @old('email') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_email') }} </span>
				</div>
				<input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" value="{{ @old('alternative_email') }}">
			</div>
		</div>

	</div>

	<input type="submit" style="display: none"  id ="submit-button">
</form>
@endsection

@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary" onclick="submitForm()">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
@endsection