@extends('default-template')

@section('title')
{{ trans('prescribers.create_prescriber') }}
@endsection 

@section('active_prescribers', 'active')

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
<i class="fas fa-user-md"></i> {{ trans('prescribers.create_prescriber') }}
@endsection


@section('content')
<form method="post" action="{{ route('prescribers/store') }}">
	@csrf

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
		</div>
		<input type="text" class="form-control" name="full_name" required>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
		</div>

		<input type="text" class="form-control" name="phone">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.email') }} </span>
		</div>

		<input type="email" class="form-control" name="email">
	</div>


	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="provincial_enrollment" min="0">

		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="national_enrollment" min="0">
	</div>

	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


