@extends('administrators/settings/index')

@section('title')
{{ trans('roles.edit_role') }}
@endsection

@section('js')
<script type="module">
    $(document).ready(function() {

        if ($('#isLabStaff').prop('checked')) 
        {
            $('#labStaffEnviroment').show(1000);
            $('#patientEnviroment').hide(0);
        } else if ($('#isUser').prop('checked')) 
        {
            $('#patientEnviroment').show(1000);
            $('#labStaffEnviroment').hide(0);
        }

        checkLabStaffPermissions();
        
    });
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/roles/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('roles.edit_role') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Carefully edit the permissions you assign to a role, the changes will be reflected immediately
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/roles/update', ['id' => $role->id]) }}">
    @csrf
    @method('PUT')

    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label for="name"> {{ trans('roles.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $role->name }}" aria-describedby="nameHelp" required>
                    
            <small id="nameHelp" class="form-text text-muted"> This name is used to identify a role </small>
        </div>
    </div>

    <div class="mt-3">
        <h4> Access enviroment </h4>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="is lab staff" name="permissions[]" id="isLabStaff" @if ($role->permissions->where('name', 'is lab staff')->first()) checked @endif>

                    <label class="form-check-label" for="isLabStaff">
                        Is lab staff
                    </label>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="is user" name="permissions[]" id="isUser" @if ($role->permissions->where('name', 'is user')->first()) checked @endif>

                    <label class="form-check-label" for="isUser">
                        Is user
                    </label>
                </div>
            </div>
        </div>
    </div>  

    @include('administrators.settings.roles.lab_staff_environment')
    @include('administrators.settings.roles.patient_environment')

    @section('environments') @show

    <input type="submit" class="btn btn-lg btn-danger mt-4" value="⚠️ {{ trans('forms.save') }}">
</form>
@endsection