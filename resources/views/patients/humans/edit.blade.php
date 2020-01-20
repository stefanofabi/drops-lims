@extends('default-template')

@section('js')


<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#sex option[value='{{ $human['sex'] ?? '' }}']").attr("selected",true);
    });
</script>

@include('patients/phones/js')
@include('patients/emails/js')
@include('patients/social_works/affiliates/js')

@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
@include('patients/edit_menu')
@endsection


@section('content-title')
{{ trans('patients.edit_patient') }}
@endsection


@section('content')

@include('patients/phones/edit')
@include('patients/emails/edit')
@include('patients/social_works/affiliates/edit')

<form method="post" action="{{ route('patients/humans/update', ['id' => $human['id']]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> {{ trans('forms.complete_personal_data') }} </h4>
		</div>

		<div class="card-body">

			<div class="input-group mb-3 col-md-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.dni') }} </span>
				</div>
				<input type="number" class="form-control" name="dni" value="{{ $human['dni'] }}">
			</div>

			<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.last_name') }} </span>
				</div>
				<input type="text" class="form-control" name="last_name" value="{{ $human['last_name'] }}" required>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>
				<input type="text" class="form-control" name="name" value="{{ $human['name'] }}" required>
			</div>

			<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control" name="home_address" value="{{ $human['home_address'] }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ $human['city'] }}">
			</div>

			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.sex') }} </span>
				</div>

				<select class="form-control input-sm" id="sex" name="sex" required>
					<option value=""> {{ trans('patients.select_sex') }} </option>
					<option value="F"> {{ trans('patients.female') }} </option>
					<option value="M"> {{ trans('patients.male') }} </option>
				</select>
			</div>


			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
				</div>

				<input type="date" class="form-control" name="birth_date" value="{{ $human['birth_date'] }}">
			</div>

		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-book"></i> {{ trans('forms.complete_contact_information') }} </h4>
		</div>

		<div class="card-body">

			@include('patients/phones/index')
			@include('patients/emails/index')

		</div>
	</div>

	@include('patients/social_works/affiliates/index')

	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection