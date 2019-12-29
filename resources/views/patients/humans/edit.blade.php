@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#sex option[value='{{ $human['sex'] ?? '' }}']").attr("selected",true);
    });
</script>


<script type="text/javascript">
	function unlock(){
		/** Desbloquea el formulario */
		$("#dni").prop("disabled", false);
		$("#surname").prop("disabled", false);
		$("#name").prop("disabled", false);
		$("#home_address").prop("disabled", false);
		$("#city").prop("disabled", false);
		$("#sex").prop("disabled", false);
		$("#birth_date").prop("disabled", false);
		$("#select_phone").prop("disabled", false);
		$("#select_email").prop("disabled", false);

		alert("{{ trans('patients.patient_unlocked') }}");

	// Hide alert
	$("#patient_blocked").css("display", "none");
	
	// Show div
	$("#save_form").css("display", "");

	// Show buttons
	$("#select_phones").css("display", "");
	$("#select_emails").css("display", "");


	return false;
}
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
{{ trans('patients.edit_patient') }}
@endsection


@section('content')

<div id="patient_blocked" class="alert alert-info fade show">
	<button type="button" class="btn btn-primary btn-sm" onclick="return unlock()"> <span class="fas fa-lock-open"></span> </button>  
	{{ trans('patients.patient_blocked') }}
</div>

<form method="post" action="{{ route('patients/humans/update', ['id' => $human['id']]) }}">
	@csrf
	{{ method_field('PUT') }}

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
				<input type="number" class="form-control" id="dni" name="dni" value="{{ $human['dni'] }}" disabled>
			</div>

			<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.surname') }} </span>
				</div>
				<input type="text" class="form-control" id="surname" name="surname" value="{{ $human['surname'] }}" disabled required>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>
				<input type="text" class="form-control" id="name" name="name" value="{{ $human['name'] }}" disabled required>
			</div>

			<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control" id="home_address" name="home_address" value="{{ $human['home_address'] }}" disabled>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" id="city" name="city" value="{{ $human['city'] }}" disabled required>
			</div>

			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.sex') }} </span>
				</div>

				<select class="form-control input-sm" id="sex" name="sex" disabled required>
					<option value=""> {{ trans('patients.select_sex') }} </option>
					<option value="F"> {{ trans('patients.female') }} </option>
					<option value="M"> {{ trans('patients.male') }} </option>
				</select>
			</div>


			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
				</div>

				<input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $human['birth_date'] }}" disabled>
			</div>

		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-book"></i> Completar datos de contacto </h4>
		</div>

		<div class="card-body">


			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phones') }} </span>
				</div>

				<select class="form-control input-sm col-md-6" style="margin-right: 1%" id="select_phone" disabled>
					<option value=""> {{ trans('patients.select_phone') }}</option>
				</select>

				<div id="select_phones" style="display: none">
					<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#nuevoTelefonoBaul">
						<span class="fas fa-plus"></span> 
					</button>

					<button type="button" class="btn btn-info btn-md" onclick="return eliminarTelefonoBaul()">
						<span class="fas fa-trash"></span> 
					</button>
				</div>
			</div>


			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.emails') }} </span>
				</div>

				<select class="form-control input-sm col-md-6" style="margin-right: 1%" id="select_email" disabled>
					<option value=""> {{ trans('patients.select_email') }}</option>
				</select>

				<div id="select_emails" style="display: none">
					<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#nuevoTelefonoBaul">
						<span class="fas fa-plus"></span> 
					</button>

					<button type="button" class="btn btn-info btn-md" onclick="return eliminarTelefonoBaul()">
						<span class="fas fa-trash"></span> 
					</button>
				</div>
			</div>


		</div>
	</div>

	<div id="save_form" class="float-right" style="display: none;margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('patients.save') }}
		</button>
	</div>	
</form>
@endsection