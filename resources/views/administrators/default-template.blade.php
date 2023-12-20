@extends('default-template')

@section('navbar')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow rounded-3 mt-3 ms-2 me-2">
	<div class="container-fluid">
        <a class="navbar-brand" href="{{ route('administrators/dashboard') }}"> <img src="{{ asset(Drops::getSystemParameterValueByKey('LOGO_IMAGE')) }}" width="104" height="35" title="Drops Lims" alt="Drops logo that simulates a drop"> </a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link @yield('active_patients') @cannot('manage patients') disabled @endcannot" href="{{ route('administrators/patients/index', ['page' => 1]) }}"> {{ trans('patients.patients') }} </a>
				</li>

					
				<li class="nav-item">
					<a class="nav-link @yield('active_prescribers') @cannot('manage prescribers') disabled @endcannot" href="{{ route('administrators/prescribers/index', ['page' => 1]) }}"> {{ trans('prescribers.prescribers') }}</a>
				</li>

					
				<li class="nav-item">
					<a class="nav-link @yield('active_determinations') @cannot('manage determinations') disabled @endcannot" href="{{ route('administrators/determinations/index', ['page' => 1]) }}"> {{ trans('determinations.determinations') }} </a>
				</li>
					
				<li class="nav-item">
					<a class="nav-link @yield('active_protocols') @cannot('manage protocols') disabled @endcannot" href="{{ route('administrators/protocols/index', ['page' => 1]) }}"> {{ trans('protocols.protocols') }} </a>
				</li>
			</ul>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
			</form>

			<!-- Show when screen is wide -->
			<div class="d-none d-md-block ms-auto">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
							<img height="30px" width="30px" src="{{ Gravatar::get(Auth::user()->email) }}" class="rounded-circle" alt="Avatar"> {{ Auth::user()->full_name }}
						</a>

						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item" href="{{ route('administrators/profiles/edit', ['id' => Auth::user()->id]) }}"> {{ trans('auth.signed_in_as', ['user' => Auth::user()->full_name ]) }} </a>
							</li>

							<div role="none" class="dropdown-divider"> </div>

							<li>
								<a class="dropdown-item @cannot('manage settings') disabled @endcannot" href="{{ route('administrators/settings/index') }}">
									{{ trans('settings.settings') }}
								</a>
							</li>

							<li>
								<a class="dropdown-item @cannot('view logs') disabled @endcannot" href="{{ route('administrators/logs/activity_logs') }}" target="_blank"> {{ trans('settings.activity_logs') }} </a>
							</li>

							<li>
								<a class="dropdown-item @cannot('view logs') disabled @endcannot" href="{{ route('administrators/logs/system_logs') }}" target="_blank"> {{ trans('settings.system_logs') }} </a>
							</li>

							<li>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>

			<!-- Show when screen is narrow -->
			<div class="d-md-none">
				<ul class="navbar-nav">
					<li> <hr> </li>

					<li>
						<a class="dropdown-item" href="{{ route('administrators/profiles/edit', ['id' => Auth::user()->id]) }}"> {{ trans('profiles.my_profile') }} </a>
					</li>

					<li class="nav-item">
						<a class="nav-link @cannot('manage settings') disabled @endcannot" href="{{ route('administrators/settings/index') }}">
							{{ trans('settings.settings') }}
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @cannot('view logs') disabled @endcannot" href="{{ route('administrators/logs/activity_logs') }}" target="_blank"> {{ trans('settings.activity_logs') }} </a>
					</li>

					<li class="nav-item">
						<a class="nav-link @cannot('view logs') disabled @endcannot" href="{{ route('administrators/logs/system_logs') }}" target="_blank"> {{ trans('settings.system_logs') }} </a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
@endsection