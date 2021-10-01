@extends('administrators/patients/create')

@section('content')
<form method="post" action="{{ route('administrators/patients/store') }}">
	@csrf

	<input type="hidden" name="type" value="industrial">

	<div class="col-10">
		<h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>

			<input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required>
		</div>

		<div class="mt-3">
			<h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
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

		<div class="mt-3">
			<h4><i class="fas fa-id-card"></i> {{ trans('patients.tax_data') }} </h4>
			<hr class="col-6">
			
			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
				</div>
				
				<input type="text" class="form-control" name="business_name" value="{{ old('business_name') }}">
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.identification_number') }} </span>
				</div>
				<input type="number" class="form-control" name="identification_number" value="{{ old('identification_number') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>
				<select class="form-select input-sm" name="tax_condition_id" id="taxCondition">
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
				<input type="text" class="form-control" name="address" value="{{ old('address') }}">

				<div class="input-group-prepend">
						<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ old('city') }}">
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity" value="{{ old('start_activity') }}">
			</div>
		</div>
	</div>

	<input type="submit" style="display: none" id="submit-button">
</form>
@endsection

@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary" onclick="submitForm()">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
@endsection