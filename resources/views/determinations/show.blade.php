@extends('default-template')

@section('title')
{{ trans('determinations.show_determination') }}
@endsection 

@section('active_determinations', 'active')

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
{{ trans('determinations.show_determination') }}
@endsection


@section('content')
<div class="alert alert-info fade show">
	<a href="{{ route('determinations/edit', [$determination['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('determinations.determination_blocked') }}
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
	</div>

	<input type="text" class="form-control" value="{{ $determination['nomenclator'] }}" disabled>
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.code') }} </span>
	</div>

	<input type="number" class="form-control" value="{{ $determination['code'] }}" disabled>
</div>

<div class="input-group mb-9 col-md-9 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.name') }} </span>
	</div>

	<input type="text" class="form-control" value="{{ $determination['name'] }}" disabled>
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.position') }} </span>
	</div>

	<input type="number" class="form-control" value="{{ $determination['position'] }}" disabled>
</div>

<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
	</div>
	<input type="number" class="form-control" value="{{ $determination['biochemical_unit'] }}" disabled>
</div>

@endsection	


