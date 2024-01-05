@extends('administrators/default-template')

@section('title')
{{ trans('profiles.my_profile') }}
@endsection

@section('js')
<script type="module">
	$(document).ready(function() {
        // Select a option from list
        $('#lang').val("{{ old('lang') ?? $user->lang }}");
    });
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/profiles/edit', ['id' => $user->id]) }}"> {{ trans('profiles.my_profile') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @cannot('sign practices') disabled @endcannot" href="{{ route('administrators/profiles/signatures/edit', ['id' => $user->id]) }}"> {{ trans('profiles.change_signature') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/profiles/passwords/edit', ['id' => $user->id]) }}"> {{ trans('auth.change_password') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-user"></i> {{ trans('profiles.my_profile') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('profiles.profile_edit_message') }}
</p>
@endsection

@section('content')
<div class="mt-3">
    <form method="post" action="{{ route('administrators/profiles/update', $user->id) }}">
        @csrf
        @method('PUT')
        
        <div class="mt-3">
            <h4> <i class="fa-solid fa-file-lines"></i> {{ trans('profiles.account_data') }} </h4>
            <hr class="col-6">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="name"> {{ trans('profiles.name') }} </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $user->name }}" aria-describedby="nameHelp" required>

                    <small id="nameHelp" class="form-text text-muted"> {{ trans('profiles.name_help') }} </small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="last_name"> {{ trans('profiles.last_name') }} </label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') ?? $user->last_name }}" aria-describedby="lastNameHelp" required>

                    <small id="lastNameHelp" class="form-text text-muted"> {{ trans('profiles.last_name_help') }} </small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="email"> {{ trans('profiles.email') }} </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?? $user->email }}" aria-describedby="emailHelp" required>

                    <small id="emailHelp" class="form-text text-muted"> {{ trans('profiles.email_help') }} </small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="lang"> {{ trans('profiles.lang') }} </label>
                    <select class="form-select @error('lang') is-invalid @enderror" name="lang" id="lang" aria-describedby="langHelp" required>
                        <option value=""> {{ trans('forms.select_option') }} </option>
                        <option value="en"> {{ trans('lang.english') }} </option>
                        <option value="es"> {{ trans('lang.spanish') }} </option>
                    </select>

                    <small id="langHelp" class="form-text text-muted"> {{ trans('profiles.lang_help') }} </small>
                </div>
            </div>
        </div>

        @can('sign practices')
        <div class="mt-4">
            <h4> <i class="fa-solid fa-id-card"></i> {{ trans('profiles.enrollment') }} </h4>
            <hr class="col-6">
        </div>
        
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="primary_enrollment"> {{ trans('profiles.primary_enrollment') }} </label>
                    <input type="text" class="form-control @error('primary_enrollment') is-invalid @enderror" name="primary_enrollment" id="primary_enrollment" value="{{ old('primary_enrollment') ?? $user->primary_enrollment }}" aria-describedby="primaryEnrollmentHelp">

                    <small id="primaryEnrollmentHelp" class="form-text text-muted"> {{ trans('profiles.primary_enrollment_help') }} </small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="secondary_enrollment"> {{ trans('profiles.secondary_enrollment') }} </label>
                    <input type="text" class="form-control @error('secondary_enrollment') is-invalid @enderror" name="secondary_enrollment" id="secondary_enrollment" value="{{ old('secondary_enrollment') ?? $user->secondary_enrollment }}" aria-describedby="secondaryEnrollmentHelp">

                    <small id="secondaryEnrollmentHelp" class="form-text text-muted"> {{ trans('profiles.secondary_enrollment_help') }} </small>
                </div>
            </div>
        </div>
        @endcan

        <input type="submit" class="btn btn-lg btn-primary float-start mt-3" id="submitButton" value="{{ trans('forms.save') }}">
    </form>
</div>
@endsection
