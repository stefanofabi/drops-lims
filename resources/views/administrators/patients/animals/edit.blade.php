@extends('administrators/default-template')

@section('js')
<script type="text/javascript">

	function updatePatient() {
		var form = document.getElementById('update_patient');
		form.submit();
	}

	$(document).ready(function() {
        // Select a sex from list
        $('#sex').val('{{ $patient->sex }}');
    });
</script>

@include('administrators/patients/phones/js')
@include('administrators/patients/emails/js')
@include('administrators/patients/social_works/affiliates/js')

@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/phones/create', $patient->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('phones.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/emails/create', $patient->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('emails.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/social_works/affiliates/create', $patient->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('social_works.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/show', $patient->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>	
</ul>
@endsection


@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection


@section('content')

@include('administrators/patients/phones/edit')
@include('administrators/patients/emails/edit')
@include('administrators/patients/social_works/affiliates/edit')



<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('forms.complete_personal_data') }} </h4>
	</div>

	<div class="card-body">
		<form id="update_patient" method="post" action="{{ route('administrators/patients/update', $patient->id) }}">
			@csrf
			{{ method_field('PUT') }}

			<div class="input-group mt-2 col-md-9">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.owner') }} </span>
				</div>
				<input type="text" class="form-control" name="owner" value="{{ $patient->owner }}" required>
			</div>

			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
				</div>
				<input type="text" class="form-control" name="full_name" value="{{ $patient->full_name }}" required>
			</div>

			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control" name="address" value="{{ $patient->address }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ $patient->city }}">
			</div>

			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.sex') }} </span>
				</div>

				<select class="form-control input-sm" id="sex" name="sex" required>
					<option value=""> {{ trans('patients.select_sex') }} </option>
					<option value="F"> {{ trans('patients.female') }} </option>
					<option value="M"> {{ trans('patients.male') }} </option>
				</select>
			</div>


			<div class="input-group mt-2 col-md-9 input-form">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
				</div>

				<input type="date" class="form-control" name="birth_date" value="{{ $patient->birth_date }}">
			</div>

			<input type="submit" style="display: none;">

		</form>
	</div>

	<div class="card-footer">
			<div class="text-right">
				<button onclick="updatePatient();" class="btn btn-primary">
					<span class="fas fa-save"></span> {{ trans('forms.save') }}
				</button>
			</div>
	</div>
</div>


<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('forms.complete_contact_information') }} </h4>
	</div>

	<div class="card-body">

		@include('administrators/patients/phones/index')
		@include('administrators/patients/emails/index')

	</div>
</div>

@include('administrators/patients/social_works/affiliates/index')

@endsection