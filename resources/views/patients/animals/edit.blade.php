@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#sex option[value='{{ $animal['sex'] ?? '' }}']").attr("selected",true);
    });
</script>
@endsection

@section('title')
{{ trans('patients.edit_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/phones/create', [$animal['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/emails/create', [$animal['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/animals/show', [$animal['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.go_back') }} </a>
	</li>	
</ul>
@endsection


@section('content-title')
{{ trans('patients.edit_patient') }}
@endsection


@section('content')
<form method="post" action="{{ route('patients/animals/update', ['id' => $animal['id']]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> {{ trans('patients.complete_personal_data') }} </h4>
		</div>

		<div class="card-body">

			<div class="input-group mb-6 col-md-6">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.owner') }} </span>
				</div>
				<input type="text" class="form-control" name="owner" value="{{ $animal['owner'] }}" required>
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>
				<input type="text" class="form-control" name="name" value="{{ $animal['name'] }}" required>
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control" name="home_address" value="{{ $animal['home_address'] }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ $animal['city'] }}">
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

				<input type="date" class="form-control" name="birth_date" value="{{ $animal['birth_date'] }}">
			</div>

		</div>
	</div>


	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-book"></i> {{ trans('patients.complete_contact_information') }} </h4>
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