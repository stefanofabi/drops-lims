@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
    $(document).ready(function() 
    {
		@if (sizeof($errors) > 0)
		enableSubmitForm();
		@endif
    });

    function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');

        $("#submitButton").removeAttr('disabled');
	}
</script>
@endsection

@section('title')
{{ trans('prescribers.edit_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('prescribers.edit_prescriber') }}
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('prescribers.prescriber_blocked') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/prescribers/update', $prescriber->id) }}">
	@csrf
	{{ method_field('PUT') }}


	<div class="col-10 mt-3">
        <h4><i class="fas fa-book"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') ?? $prescriber->full_name }}" required readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
            </div>

            <input type="text" class="form-control" name="phone" value="{{ old('phone') ?? $prescriber->phone }}" readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.email') }} </span>
            </div>

            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $prescriber->email }}" readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="provincial_enrollment" min="0" value="{{ old('provincial_enrollment') ?? $prescriber->provincial_enrollment }}" readonly>

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="national_enrollment" min="0" value="{{ old('national_enrollment') ?? $prescriber->national_enrollment }}" readonly>
        </div>
	</div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" id="submitButton" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection