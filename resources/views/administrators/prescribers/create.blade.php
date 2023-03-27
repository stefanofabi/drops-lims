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
    {{ trans('prescribers.prescribers_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/prescribers/store') }}">
	@csrf

    <div class="mt-4">
        <h4><i class="fas fa-book"></i> {{ trans('prescribers.personal_data') }} </h4>
		<hr class="col-6">
    </div>
    
	<div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="name"> {{ trans('prescribers.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>

                <small id="nameHelp" class="form-text text-muted"> {{ trans('prescribers.name_help') }} </small>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="last_name"> {{ trans('prescribers.last_name') }} </label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') }}" aria-describedby="lastNameHelp" required>

                <small id="lastNameHelp" class="form-text text-muted"> {{ trans('prescribers.last_name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="primary_enrollment"> {{ trans('prescribers.primary_enrollment') }} </label>
                <input type="text" class="form-control @error('primary_enrollment') is-invalid @enderror" name="primary_enrollment" id="primary_enrollment" value="{{ old('primary_enrollment') }}" aria-describedby="primaryEnrollmentHelp">
                
                <small id="primaryEnrollmentHelp" class="form-text text-muted"> {{ trans('prescribers.primary_enrollment_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="secondary_enrollment"> {{ trans('prescribers.secondary_enrollment') }} </label>
                <input type="text" class="form-control @error('secondary_enrollment') is-invalid @enderror" name="secondary_enrollment" id="secondary_enrollment" value="{{ old('secondary_enrollment') }}" aria-describedby="secondaryEnrollmentHelp">
                
                <small id="secondaryEnrollmentHelp" class="form-text text-muted"> {{ trans('prescribers.secondary_enrollment_help') }} </small>
            </div>
        </div>
	</div>

    <div class="mt-4">
        <h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="phone"> {{ trans('prescribers.phone') }} </label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" aria-describedby="phoneHelp">

                <small id="phoneHelp" class="form-text text-muted"> {{ trans('prescribers.phone_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="email"> {{ trans('prescribers.email') }} </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" aria-describedby="emailHelp">
                
                <small id="emailHelp" class="form-text text-muted"> {{ trans('prescribers.email_help') }} </small>
            </div>
        </div>
    </div>
    
    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection