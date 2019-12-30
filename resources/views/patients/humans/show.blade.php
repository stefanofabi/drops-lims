@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#sex option[value='{{ $human['sex'] ?? '' }}']").attr("selected",true);
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

<div class="alert alert-info fade show">
	<a href="{{ route('patients/humans/edit', [$human['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>


<div class="card">
	<div class="card-header">
		<h4><i class="fas fa-toolbox"></i> {{ trans('patients.shunt') }} </h4>
	</div>
	<div class="card-body">
		<div class="input-group mb-6 col-md-6">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.shunt') }} </span>
			</div>
			<input type="text" class="form-control" name="shunt" value="{{ $human['shunt'] }}" disabled>
		</div>
	</div>
</div>

<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
	</div>

	<div class="card-body">

		<div class="input-group mb-3 col-md-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.dni') }} </span>
			</div>
			<input type="number" class="form-control" name="dni" value="{{ $human['dni'] }}" disabled>
		</div>

		<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.surname') }} </span>
			</div>
			<input type="text" class="form-control" name="surname" value="{{ $human['surname'] }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.name') }} </span>
			</div>
			<input type="text" class="form-control" name="name" value="{{ $human['name'] }}" disabled>
		</div>

		<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
			</div>
			<input type="text" class="form-control" name="home_address" value="{{ $human['home_address'] }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" name="city" value="{{ $human['city'] }}" disabled>
		</div>

		<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-control input-sm" id="sex" name="sex" disabled>
				<option value=""> {{ trans('patients.select_sex') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>


		<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control" name="birth_date" value="{{ $human['birth_date'] }}" disabled>
		</div>

	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('patients.contact_information') }} </h4>
	</div>

	<div class="card-body">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.phones') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" style="margin-right: 1%">
				<option value=""> {{ trans('patients.select_phone') }}</option>
			</select>
		</div>


		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.emails') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" style="margin-right: 1%">
				<option value=""> {{ trans('patients.select_email') }}</option>
			</select>
		</div>


	</div>
</div>

@endsection