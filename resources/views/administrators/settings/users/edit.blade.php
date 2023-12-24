@extends('administrators/settings/index')

@section('title')
{{ trans('users.edit_user') }}
@endsection

@section('js')
<script type="module">
	$(document).ready(function() {
        // Select a option from list
        $('#role').val("{{ old('role') ?? $user->roles->first()->id ?? '' }}");
    });
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/users/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-user-pen"></i> {{ trans('users.edit_user') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('users.users_edit_content_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/users/update', ['id' => $user->id]) }}">
    @csrf
    @method('PUT')

    <div class="mt-4">
        <h4><i class="fas fa-id-card"></i> {{ trans('users.personal_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6 mt-0 mt-md-0">
            <div class="form-group">
                <label for="name"> {{ trans('users.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $user->name }}" aria-describedby="nameHelp" minlength="2" required>
                        
                <small id="nameHelp" class="form-text text-muted"> {{ trans('users.name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6 mt-3 mt-md-0">
            <div class="form-group">
                <label for="last_name"> {{ trans('users.last_name') }} </label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') ?? $user->last_name }}" aria-describedby="lastNameHelp" minlength="2" required>
                        
                <small id="lastNameHelp" class="form-text text-muted"> {{ trans('users.last_name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="email"> {{ trans('users.email') }} </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?? $user->email }}" aria-describedby="emailHelp" required>
                        
                <small id="emailHelp" class="form-text text-muted"> {{ trans('users.email_help') }} </small>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="form-group mt-2">
                <label for="role"> {{ trans('users.role') }} </label>
                <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" aria-describedby="roleHelp" required>
                    <option value=""> {{ trans('forms.select_option') }} </option>

                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}"> {{ $role->name }} </option>      
                    @endforeach
                </select>

                <small id="roleHelp" class="form-text text-muted"> {{ trans('users.role_help') }} </small>
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-4" value="{{ trans('forms.save') }}">
</form>
@endsection