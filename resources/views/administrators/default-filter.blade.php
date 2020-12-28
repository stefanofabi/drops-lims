@extends('default-filter')

@section('home-href')
{{ route('administrators/home') }}
@endsection

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

		</ul>
	</div>
@endsection
