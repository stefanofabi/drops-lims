@extends('default-filter')

@section('navbar_menu')
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link @yield('active_patients')" href="{{ route('administrators/patients') }}"> {{ trans('patients.patients') }} </a>
			</li>

			<li class="nav-item">
				<a class="nav-link @yield('active_prescribers')" href="{{ route('administrators/prescribers') }}"> {{ trans('prescribers.prescribers') }}</a>
			</li>

			<li class="nav-item">
				<a class="nav-link @yield('active_determinations')" href="{{ route('administrators/determinations') }}"> {{ trans('determinations.determinations') }} </a>
			</li>

			<li class="nav-item">
				<a class="nav-link @yield('active_protocols')" href="{{ route('administrators/protocols') }}"> {{ trans('protocols.protocols') }} </a>
			</li>

			<div class="dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Ajustes
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Link 1</a>
					<a class="dropdown-item" href="#">Link 2</a>
					<a class="dropdown-item" href="#">Link 3</a>
				</div>
			</div>


			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>

		<!-- Right Side Of Navbar -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
					{{ Auth::user()->name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="{{ route('logout') }}"
					onclick="event.preventDefault();
					document.getElementById('logout-form').submit();">
					{{ trans('auth.logout') }}
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</div>
			</li>
		</ul>
	</div>
@endsection