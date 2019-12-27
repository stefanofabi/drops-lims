@extends('patients/create')

@section('content')
<form method="post" action="{{ route('patients/humans/store') }}">
	@csrf
	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> Completar derivador </h4>
		</div>
		<div class="card-body">

			<div class="input-group mb-4 col-md-4">
				<div class="input-group-prepend">
					<span class="input-group-text"> Derivador </span>
				</div>
					<select class="form-control" name="shunt" required>
						<option value=""> Seleccione un derivador</option>
						@foreach ($shunts as $shunt)
						<option value="{{ $shunt->id }}"> {{ $shunt->name }}</option>
						@endforeach
					</select>
			</div>
		</div>
	</div>

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> Completar datos personales </h4>
		</div>

		<div class="card-body">

			<div class="input-group mb-6 col-md-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> DNI </span>
				</div>
				<input type="number" class="form-control" name="dni">
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> Apellido </span>
				</div>
				<input type="text" class="form-control" name="surname" required>

				<div class="input-group-prepend">
					<span class="input-group-text"> Nombre </span>
				</div>
				<input type="text" class="form-control" name="name" required>
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> Domicilio </span>
				</div>
				<input type="text" class="form-control" name="home_address">

				<div class="input-group-prepend">
					<span class="input-group-text"> Ciudad </span>
				</div>
				<input type="text" class="form-control" name="city" required>
			</div>

			<div class="input-group mb-6 col-md-3 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> Sexo </span>
				</div>

				<select class="form-control input-sm" name="sex" required>
					<option value=""> Seleccione sexo</option>
					<option value="F"> Femenino</option>
					<option value="M"> Masculino </option>
				</select>
			</div>


			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> Fecha de nacimiento </span>
				</div>

				<input type="date" class="form-control" name="birth_date">
			</div>

		</div>
	</div>

		<div class="float-right">
			<button type="submit" class="btn btn-primary">
				<span class="fas fa-save"></span> Guardar
			</button>
		</div>	
</form>
@endsection