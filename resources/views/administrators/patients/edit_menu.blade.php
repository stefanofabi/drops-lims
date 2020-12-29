<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/phones/create', $patient->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('phones.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/emails/create', $patient->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('emails.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/social_works/affiliates/create', $patient->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('social_works.add_social_work') }} </a>
	</li>
</ul>