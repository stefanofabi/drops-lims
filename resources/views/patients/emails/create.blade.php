@extends('default-template')

@section('title')
{{ trans('patients.add_email') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/phones/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/emails/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/show', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
{{ trans('patients.add_email') }}
@endsection


@section('content')
<form method="post" action="{{ route('patients/emails/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="id" value="{{ $id }}">

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.email') }} </span>
		</div>

		<input type="email" class="form-control" name="email" required>
	</div>


	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('patients.save') }}
		</button>
	</div>	
</form>
@endsection	


