@extends('patients/patients')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>Paciente</th>
				<th>DNI</th>
				<th>Ciudad</th>
				<th>Domicilio</th>  
				<th>Fecha nacimiento</th>
				<th class="text-right"> Acciones</th>
			</tr>

			@foreach ($data as $patient)
			<tr>
				<td> {{ $patient->surname }}, {{ $patient->name }} </td>
				<td> {{ $patient->dni }} </td>
				<td> {{ $patient->city }} </td>
				<td> {{ $patient->home_address }} </td>
				<td> {{ $patient->birth_date }} </td>

				<td class="text-right">
					<a href="#" class="btn btn-info btn-sm" title="Editar paciente" > <i class="fas fa-user-edit fa-sm"></i> </a> 
					<a href="#" class="btn btn-info btn-sm" title="Borrar paciente" onclick=""> <i class="fas fa-user-slash fa-sm"></i> </a>
				</td>
			</tr>
			@endforeach


			<tr>
				<td colspan=7>
					<span class="float-right">
							{!! $paginate !!}
					</span>
				</td>
			</tr>

		</table>
	</div>
</div>
@endsection
