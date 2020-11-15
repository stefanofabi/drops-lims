@extends('patients/default-template')

@section('title')
{{ trans('patients.add_family_member') }}
@endsection

@section('active_family_members', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
    </li>
</ul>
@endsection


@section('content-title')
<i class="fas fa-user-plus"></i> {{ trans('patients.add_family_member') }}
@endsection

@section('content')

    <div class="mb-4">
        {{ trans('patients.notice_add_family_member') }}
    </div>

    <form method="post" action="{{ route('patients/family_members/store') }}">
        @csrf

        <div class="input-group mt-2 col-md-9">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.unique_identifier') }} </span>
            </div>

            <input type="number" class="form-control @error('patient_id') is-invalid @enderror" name="patient_id" min="1" value="{{ old('patient_id') }}" required>

            @error('patient_id')
                <span class="invalid-feedback" role="alert">
                    <strong> {{ $message }} </strong>
                </span>
            @enderror
        </div>

        <div class="input-group mt-2 col-md-9">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.security_code') }} </span>
            </div>

            <input type="text" class="form-control @error('security_code') is-invalid @enderror" name="security_code"  required>

            @error('security_code')
                <span class="invalid-feedback" role="alert">
                    <strong> {{ $message }} </strong>
                </span>
            @enderror
        </div>

        <input class="form-control btn-primary mt-4" type="submit" value="{{ trans('forms.send') }}">
    </form>
@endsection

