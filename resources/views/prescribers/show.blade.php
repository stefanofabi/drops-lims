@extends('default-template')

@section('title')
{{ trans('prescribers.show_prescriber') }}
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
<i class="fas fa-user-shield"></i> {{ trans('prescribers.show_prescriber') }}
@endsection


@section('content')
<div class="alert alert-info fade show">
	<a href="{{ route('prescribers/edit', [$prescriber['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('prescribers.prescriber_blocked') }}
</div>

<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
	</div>
	<input type="text" class="form-control" value="{{ $prescriber['full_name'] }}" disabled>
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
	</div>

	<input type="text" class="form-control" value="{{ $prescriber['phone'] }}" disabled>
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('prescribers.email') }} </span>
	</div>

	<input type="email" class="form-control" value="{{ $prescriber['email'] }}" disabled>
</div>


<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
	</div>
	<input type="number" class="form-control" min="0" value="{{ $prescriber['provincial_enrollment'] }}" disabled>

	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
	</div>
	<input type="number" class="form-control" min="0" value="{{ $prescriber['national_enrollment'] }}" disabled>
</div>

@endsection	


