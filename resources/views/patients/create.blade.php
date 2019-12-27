@extends('default-template')

@section('title', 'Nuevo paciente') 

@section('active_patients', 'active')

@section('menu-title', 'Menú')

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/animals/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Nuevo paciente animal</a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/humans/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Nuevo paciente humano</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/industrials/create') }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Nuevo paciente industrial</a>
		</li>
	</ul>
</p>
@endsection


@section('content-title', 'Nuevo paciente')

@section('content')
	<div class="alert alert-info">
	  <strong>¡Aviso!</strong> Seleccione una opción del menú para continuar.
	</div>
@endsection

