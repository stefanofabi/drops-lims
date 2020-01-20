@extends('default-template')

@section('title')
{{ trans('prescribers.create_prescriber') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
{{ trans('prescribers.create_prescriber') }}
@endsection


@section('content')
<form method="post" action="{{ route('prescribers/store') }}">
	@csrf

	<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.last_name') }} </span>
		</div>
		<input type="text" class="form-control" name="last_name" required>

		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" required>
	</div>

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
		</div>

		<input type="text" class="form-control" name="phone">
	</div>

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.email') }} </span>
		</div>

		<input type="email" class="form-control" name="email">
	</div>


	<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="provincial_enrollment" min="0">

		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="national_enrollment" min="0">
	</div>

	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


