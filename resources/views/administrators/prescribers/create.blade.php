@extends('administrators/default-template')

@section('title')
    {{ trans('prescribers.create_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('content-title')
    <i class="fas fa-user-md"></i> {{ trans('prescribers.create_prescriber') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/prescribers/store') }}">
	@csrf

	<div class="col-10 mt-3">
        <h4><i class="fas fa-book"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
            </div>

            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.email') }} </span>
            </div>

            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="provincial_enrollment" min="0" value="{{ old('provincial_enrollment') }}">

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="national_enrollment" min="0" value="{{ old('national_enrollment') }}">
        </div>
	</div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection