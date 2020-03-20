<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/phones/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('phones.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/emails/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('emails.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/social_works/affiliates/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('social_works.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/edit', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>	
</ul>