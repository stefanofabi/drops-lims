@extends('default-template')

@section('home-href')
{{ route('patients/home') }}
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
				<li class="nav-item">
					<a class="nav-link @yield('active_results')" href="{{ route('patients/protocols/index') }}"> {{ trans('home.results') }} </a>
				</li>

                <li class="nav-item">
					<a class="nav-link @yield('active_family_members')" href="{{ route('patients/family_members/index') }}"> {{ trans('home.family_members') }} </a>
				</li>
			</ul>

			<!-- Show when screen is wide -->
			<div class="d-none d-lg-block ms-auto">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
							<img height="30px" width="30px" src="{{ Gravatar::get(Auth::user()->email) }}" class="rounded-circle" alt="Avatar"> {{ Auth::user()->name }} <span class="caret"> </span>
						</a>

						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item" href="#"> {{ trans('auth.signed_in_as', ['user' => Auth::user()->name ]) }} </a>
							</li>

							<div role="none" class="dropdown-divider"> </div>

							<li>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a>

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
				    <li class="nav-item">
						<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
						</form>
					</li>
				</ul>
			</div>
		</div>
    </div>
</nav>
@endsection
