@extends('default-template')

@section('title')
{{ trans('determinations.create_determination') }}
@endsection 

@section('active_determinations', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('determinations.add_nbu') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
{{ trans('determinations.create_determination') }}
@endsection


@section('content')
<form method="post" action="{{ route('determinations/store') }}">
	@csrf


	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
		</div>

		<select class="form-control input-sm" name="nomenclator" required>
			<option value=""> {{ trans('determinations.select_nbu') }} </option>
			@foreach ($nomenclators as $nomenclator)
			<option value="{{ $nomenclator['id'] }}"> {{ $nomenclator['name'] }} </option>
			@endforeach
		</select>
	</div>
	
	<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.code') }} </span>
		</div>

		<input type="number" class="form-control" name="code" required>
	</div>

	<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" required>
	</div>

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.position') }} </span>
		</div>

		<input type="number" class="form-control" name="position" min="0" value="1">
	</div>

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
		</div>
		<input type="number" class="form-control" name="biochemical_unit" min="0" step="0.01" value="0.0">
	</div>



	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('prescribers.save') }}
		</button>
	</div>	
</form>
@endsection	


