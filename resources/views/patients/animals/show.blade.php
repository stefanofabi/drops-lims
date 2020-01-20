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
{{ trans('patients.show_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Crear protocolo </a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Ver protocolos</a>
		</li>
	</ul>
</p>
@endsection


@section('content-title')
{{ trans('patients.show_patient') }}
@endsection


@section('content')

<div id="patient_blocked" class="alert alert-info fade show">
	<a href="{{ route('patients/animals/edit', [$animal['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>

<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('forms.personal_data') }} </h4>
	</div>

	<div class="card-body">

		<div class="input-group mb-6 col-md-6">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.owner') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $animal['owner'] }}" disabled>
		</div>

		<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.name') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $animal['name'] }}" disabled>
		</div>

		<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $animal['home_address'] }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $animal['city'] }}" disabled>
		</div>

		<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-control input-sm" id="sex" disabled>
				<option value=""> {{ trans('patients.select_sex') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>


		<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control" value="{{ $animal['birth_date'] }}" disabled>
		</div>

	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
	</div>

	<div class="card-body">
		
		@include('patients/phones/show')
		@include('patients/emails/show')

	</div>
</div>

@include('patients/social_works/affiliates/show')

@endsection