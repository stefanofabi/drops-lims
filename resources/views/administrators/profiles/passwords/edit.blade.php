@extends('administrators/profiles/edit')

@section('title')
{{ trans('auth.change_password') }}
@endsection

@section('content-title')
<i class="fa-solid fa-lock"></i> {{ trans('auth.change_password') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('profiles.change_password_edit_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/profiles/passwords/update', ['id' => $user->id]) }}">
    @csrf
    @method('PUT')

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="current_password"> {{ trans('auth.current_password') }} </label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password" value="" aria-describedby="currentPasswordHelp" required>

                <small id="currentPasswordHelp" class="form-text text-muted"> {{ trans('auth.current_password_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="new_password"> {{ trans('auth.new_password') }} </label>
                <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" value="" aria-describedby="newPaswordHelp" required>

                <small id="newPaswordHelp" class="form-text text-muted"> {{ trans('auth.new_password_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="new_password_confirmation"> {{ trans('auth.new_password_confirmation') }} </label>
                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation" value="" aria-describedby="newPasswordConfirmationHelp" required>

                <small id="newPasswordConfirmationHelp" class="form-text text-muted"> {{ trans('auth.new_password_confirmation_help') }} </small>
            </div>
        </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" id="submitButton" value="{{ trans('forms.save') }}">
</form>
@endsection
