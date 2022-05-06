@extends('patients/default-template')

@section('title')
{{ trans('patients.add_family_member') }}
@endsection

@section('active_family_members', 'active')

@section('content-title')
<i class="fas fa-user-plus"></i> {{ trans('patients.add_family_member') }}
@endsection

@section('content-message')
{{ trans('patients.notice_add_family_member') }}
@endsection

@section('content')
<form method="post" action="{{ route('patients/family_members/store') }}">
    @csrf
    
    <div class="input-group w-50 mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('patients.unique_identifier') }} </span>
        </div>

        <input type="number" class="form-control @error('internal_patient_id') is-invalid @enderror" name="internal_patient_id" min="1" value="{{ old('internal_patient_id') }}" required>

        @error('internal_patient_id')
        <span class="invalid-feedback" role="alert">
            <strong> {{ $message }} </strong>
        </span>
        @enderror
    </div>

    <div class="input-group w-50 mt-2">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('patients.security_code') }} </span>
        </div>

        <input type="text" class="form-control @error('security_code') is-invalid @enderror" name="security_code" required>

        @error('security_code')
        <span class="invalid-feedback" role="alert">
            <strong> {{ $message }} </strong>
        </span>
        @enderror
    </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection

