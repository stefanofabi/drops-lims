<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/phones/create', [$id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('phones.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/emails/create', [$id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('emails.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/social_works/affiliates/create', [$id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('social_works.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/edit', [$id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>	
</ul>