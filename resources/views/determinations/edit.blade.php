@extends('default-template')

@section('title')
{{ trans('determinations.edit_determination') }}
@endsection 

@section('active_determinations', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a nomenclator
        $("#nomenclator option[value={{ $determination['nomenclator'] ?? '' }}]").attr("selected",true);
    });
</script>
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('determinations.add_report') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('determinations/show', [$determination['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>		
</ul>
@endsection

@section('content-title')
{{ trans('determinations.edit_determination') }}
@endsection


@section('content')
<form method="post" action="{{ route('determinations/update', [$determination['id']]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mb-1 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $determination['nomenclator'] }}" disabled>
	</div>

	<div class="input-group mb-1 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.code') }} </span>
		</div>

		<input type="number" class="form-control" name="code" value="{{ $determination['code'] }}" required>
	</div>

	<div class="input-group mb-1 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" value="{{ $determination['name'] }}" required>
	</div>

	<div class="input-group mb-1 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.position') }} </span>
		</div>

		<input type="number" class="form-control" name="position" min="0" value="{{ $determination['position'] }}">
	</div>

	<div class="input-group mb-1 col-md-9 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
		</div>
		<input type="number" class="form-control" name="biochemical_unit" min="0" step="0.01" value="{{ $determination['biochemical_unit'] }}">
	</div>

	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


