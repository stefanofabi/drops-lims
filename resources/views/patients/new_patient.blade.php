@extends('default-new')

@section('title', 'Nuevo paciente') 

@section('active_patients', 'active')

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/new/animal') }}"> Nuevo paciente animal</a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/new/human') }}"> Nuevo paciente humano</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/new/industrial') }}"> Nuevo paciente industrial</a>
		</li>
	</ul>
</p>
@endsection

@section('content')
<div class="alert alert-info">
  <strong>Aviso!</strong> Seleccione una opción del menú para continuar.
</div>
@endsection

