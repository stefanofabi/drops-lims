@extends('default-template')

@section('home-href')
{{ route('administrators/home') }}
@endsection

@section('navbar')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container-fluid">
            <a class="navbar-brand" href="@yield('home-href')"> <img width="100" height="30" src="{{ asset('images/logo.png') }}"> </a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav">
					@can('crud_patients')
						<li class="nav-item">
							<a class="nav-link @yield('active_patients')" href="{{ route('administrators/patients/index', ['type' => 'human', 'page' => 1]) }}"> {{ trans('patients.patients') }} </a>
						</li>
					@endcan

					@can('crud_prescribers')
						<li class="nav-item">
							<a class="nav-link @yield('active_prescribers')" href="{{ route('administrators/prescribers/index', ['page' => 1]) }}"> {{ trans('prescribers.prescribers') }}</a>
						</li>
					@endcan

					@can('crud_determinations')
						<li class="nav-item">
							<a class="nav-link @yield('active_determinations')" href="{{ route('administrators/determinations/index', ['page' => 1]) }}"> {{ trans('determinations.determinations') }} </a>
						</li>
					@endcan

					@can('crud_protocols')
						<li class="nav-item">
							<a class="nav-link @yield('active_protocols')" href="{{ route('administrators/protocols/index', ['page' => 1]) }}"> {{ trans('protocols.protocols') }} </a>
						</li>
					@endcan
				</ul>

				<!-- Show when screen is wide -->
				<div class="d-none d-lg-block ms-auto">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
								<img height="30px" width="30px" src="{{ asset('storage/avatars/'.Auth::user()->avatar ) }}" class="rounded-circle" alt="{{ Auth::user()->avatar }}"> {{ Auth::user()->name }} <span class="caret"> </span>
							</a>

							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a class="dropdown-item" href="#"> {{ trans('auth.signed_in_as', ['user' => Auth::user()->name ]) }} </a>
								</li>

								<div role="none" class="dropdown-divider"> </div>

								@can('is_admin')
								<li>
									<a class="dropdown-item" href="{{ route('administrators/settings/index') }}">
										{{ trans('settings.settings') }}
									</a>
								</li>
								@endcan

								<li>
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				<!-- Show when screen is narrow -->
				<div class="d-lg-none">
					<ul class="navbar-nav">
					@can('is_admin')
					<li class="nav-item">
						<a class="nav-link" href="{{ route('administrators/settings/index') }}">
							{{ trans('settings.settings') }}
						</a>
					</li>
					@endcan

					<li class="nav-item">
						<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
						</form>
					</li>
				</ul>
			</div>
		</div>
</nav>
@endsection