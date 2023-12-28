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

<script type="text/javascript">
function unbanUser() {
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('unban_user');
            form.submit();
        }
}
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        @if ($user->isBanned())
        <form action="{{ route('administrators/settings/bans/unban', ['user_id' => $user->id]) }}" id="unban_user" method="post">
            @csrf
            @method('DELETE')

            <input type="submit" class="d-none"></input>
        </form>

        <li class="nav-item">
            <a href="#" class="nav-link" onclick="unbanUser()">
                {{ trans('bans.unban_user') }}
            </a>
		</li>
        @else
        <li class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#banUserModal">
                {{ trans('bans.ban_user') }}
            </a>
		</li>
        @endif

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
@if ($user->isBanned())
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <h4 class="alert-heading"> {{ trans('bans.user_banned') }} </h4>
    <p> {{ trans('bans.user_banned_message') }}</p>
    <hr>
    <div> <span class="fw-bold"> {{ trans('bans.banned_by') }}: </span> {{ \App\Models\User::find($user->bans()->notExpired()->orderBy('expired_at', 'DESC')->first()->created_by_id)->full_name ?? 'Not found' }} </div>
    <div> 
        <span class="fw-bold"> {{ trans('bans.expired_at') }}: </span> 
        @if (empty($user->bans()->notExpired()->orderBy('expired_at', 'DESC')->first()->expired_at)) 
        {{ trans('bans.permanently') }} 
        @else 
        {{ $user->bans()->notExpired()->orderBy('expired_at', 'DESC')->first()->expired_at }} 
        @endif
    </div>
    <div> <span class="fw-bold"> {{ trans('bans.comment') }}: </span> {{ $user->bans()->notExpired()->orderBy('expired_at', 'DESC')->first()->comment }} </div>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
            <div class="form-group">
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

@if ($user->isNotBanned())
@include('administrators.settings.users.ban_user_modal')
@endif
@endsection