		<nav class="navbar navbar-expand-lg navbar-dark bg-info">
			<a class="navbar-brand" href="index.php">LOGO</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link @yield('active_patients')" href="{{ route('patients') }}">Pacientes</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @yield('active_medics')" href="medicos.php"> Médicos</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @yield('active_determinations')" href="determinations.php">Determinaciones</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @yield('active_protocols')" href="protocols.php">Protocolos</a>
					</li>

				<!--
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="pacientes.php">Action</a>
								<a class="dropdown-item" href="prescriptores.php">Another action</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						-->
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
				</div>
			</nav>