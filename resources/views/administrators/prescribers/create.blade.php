@extends('administrators/default-template')

@section('title')
    {{ trans('prescribers.create_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('content-title')
    <i class="fas fa-user-md"></i> {{ trans('prescribers.create_prescriber') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Create new prescribers and assign them to different protocols. When assigned to a protocol, it allows the prescriber to see the patient's medical history.
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/prescribers/store') }}">
	@csrf

	<div class="col-10 mt-3">
        <h4><i class="fas fa-book"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

        <div class="form-group mt-2">
			<label for="name"> {{ trans('prescribers.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>

			<small id="nameHelp" class="form-text text-muted"> This name appears when generating a pdf protocol </small>
		</div>

        <div class="form-group mt-2">
			<label for="last_name"> {{ trans('prescribers.last_name') }} </label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') }}" aria-describedby="lastNameHelp" required>

			<small id="lastNameHelp" class="form-text text-muted"> This last name appears when generating a pdf protocol </small>
		</div>

        <div class="form-group mt-2">
			<label for="phone"> {{ trans('prescribers.phone') }} </label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" aria-describedby="phoneHelp">

			<small id="phoneHelp" class="form-text text-muted"> The cell phone number will be saved here to be consulted </small>
		</div>

        <div class="form-group mt-2">
			<label for="email"> {{ trans('prescribers.email') }} </label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" aria-describedby="emailHelp">
			
            <small id="emailHelp" class="form-text text-muted"> The email will be saved here to be consulted </small>
		</div>

        <div class="form-group mt-2">
			<label for="primary_enrollment"> {{ trans('prescribers.primary_enrollment') }} </label>
            <input type="text" class="form-control @error('primary_enrollment') is-invalid @enderror" name="primary_enrollment" id="primary_enrollment" value="{{ old('primary_enrollment') }}" aria-describedby="primaryEnrollmentHelp">
			
            <small id="primaryEnrollmentHelp" class="form-text text-muted"> The enrollment can be used to quickly search for a prescriber </small>
		</div>

        <div class="form-group mt-2">
			<label for="secondary_enrollment"> {{ trans('prescribers.secondary_enrollment') }} </label>
            <input type="text" class="form-control @error('secondary_enrollment') is-invalid @enderror" name="secondary_enrollment" id="secondary_enrollment" value="{{ old('secondary_enrollment') }}" aria-describedby="secondaryEnrollmentHelp">
			
            <small id="secondaryEnrollmentHelp" class="form-text text-muted"> The enrollment can be used to quickly search for a prescriber </small>
		</div>
	</div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection