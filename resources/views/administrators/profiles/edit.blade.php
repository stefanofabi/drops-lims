@extends('administrators/default-template')

@section('title')
{{ trans('profiles.my_profile') }}
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link @cannot('sign practices') disabled @endcannot" href="#"> {{ trans('profiles.change_signature') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/profiles/change_password/edit', ['id' => $user->id]) }}"> {{ trans('auth.change_password') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-address-card"></i> {{ trans('profiles.my_profile') }}
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

        </div>

        <input type="submit" class="btn btn-lg btn-primary float-start mt-3" id="submitButton" value="{{ trans('forms.save') }}">
    </form>
</div>
@endsection
