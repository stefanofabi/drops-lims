@extends('patients/default-template')

@section('title')
{{ trans('family_members.add_family_member') }}
@endsection

@section('active_family_members', 'active')

@section('content-title')
<i class="fas fa-user-plus"></i> {{ trans('family_members.add_family_member') }}
@endsection

@section('content-message')
{{ trans('family_members.notice_add_family_member') }}
@endsection

@section('content')
<form method="post" action="{{ route('patients/family_members/store') }}">
    @csrf

    <div class="row">
        <div class="col-md-9 mt-3">
            <label for="internalPatient"> {{ trans('patients.unique_identifier') }} </label>
            <input type="number" class="form-control @error('internal_patient_id') is-invalid @enderror" id="internalPatient" name="internal_patient_id" value="{{ old('internal_patient_id') }}" aria-describedby="internalPatientHelp" required>

            <small id="internalPatientHelp" class="form-text text-muted"> {{ trans('family_members.internal_patient_help') }} </small>
        </div>

        <div class="col-md-9 mt-3">
            <label for="securityCode"> {{ trans('patients.security_code') }} </label>
            <input type="text" class="form-control @error('security_code') is-invalid @enderror" id="securityCode" name="security_code" value="" aria-describedby="securityCodeHelp" required>

            <small id="securityCodeHelp" class="form-text text-muted"> {{ trans('family_members.security_code_help') }} </small>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection

