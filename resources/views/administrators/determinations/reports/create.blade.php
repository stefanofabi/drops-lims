@extends('administrators/default-template')

@section('title')
{{ trans('reports.create_report') }}
@endsection 

@section('active_determinations', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>	

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/determinations/edit', $determination->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-pdf"></i> {{ trans('reports.create_report') }}
@endsection


@section('content')
<div class="alert alert-warning">
	<strong>{{ trans('forms.warning') }}!</strong> {{ trans('reports.creation_notice') }}
</div>

<form method="post" action="{{ route('administrators/determinations/reports/store') }}">
	@csrf
	
	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="hidden" name="determination_id" value="{{ $determination->id }}">
		<input type="text" class="form-control" value="{{ $determination->name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" required>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>

		<textarea class="form-control" rows="10" name="report"></textarea>
	</div>

	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


