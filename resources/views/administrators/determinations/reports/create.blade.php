@extends('administrators/default-template')

@section('title')
{{ trans('reports.create_report') }}
@endsection 

@section('active_determinations', 'active')

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/determinations/reports/index', ['determination_id' => $determination->id]) }}"> {{ trans('forms.go_back') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-alt"></i> {{ trans('reports.create_report') }}
@endsection

@section('content')
<div class="alert alert-warning mt-3">
	<strong>{{ trans('forms.warning') }}!</strong> {{ trans('reports.creation_notice') }}
</div>

<form method="post" action="{{ route('administrators/determinations/reports/store') }}">
	@csrf
	
	<input type="hidden" name="determination_id" value="{{ $determination->id }}">

	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>
		
		<input type="text" class="form-control" value="{{ $determination->name }}" disabled>
	</div>

	<div class="input-group mt-2">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
	</div>

	<div class="input-group mt-2">
		<span class="input-group-text"> {{ trans('reports.report') }} </span>

		<textarea class="form-control" rows="10" name="report">{{ old('report') }}</textarea>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection	


