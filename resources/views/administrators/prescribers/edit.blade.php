@extends('administrators/default-template')

@section('title')
{{ trans('prescribers.edit_prescriber') }}
@endsection 

@section('active_prescribers', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/prescribers/show', $prescriber->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('prescribers.edit_prescriber') }}
@endsection


@section('content')
<form method="post" action="{{ route('administrators/prescribers/update', $prescriber->id) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
		</div>
		<input type="text" class="form-control" name="full_name" value="{{ $prescriber->full_name }}" required>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
		</div>

		<input type="text" class="form-control" name="phone" value="{{ $prescriber->phone }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.email') }} </span>
		</div>

		<input type="email" class="form-control" name="email" value="{{ $prescriber->email }}">
	</div>


	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="provincial_enrollment" min="0" value="{{ $prescriber['provincial_enrollment'] }}">

		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
		</div>
		<input type="number" class="form-control" name="national_enrollment" min="0" value="{{ $prescriber['national_enrollment'] }}">
	</div>

	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


