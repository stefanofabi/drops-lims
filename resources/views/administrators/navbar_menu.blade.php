<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav me-auto">
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
</div>