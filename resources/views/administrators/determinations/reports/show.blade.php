@extends('administrators/default-template')

@section('title')
{{ trans('reports.show_report') }}
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
		<a class="nav-link" href="{{ route('administrators/determinations/show', ['id' => $report->determination->id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-pdf"></i> {{ trans('reports.show_report') }}
@endsection


@section('content')
	<div class="alert alert-info fade show">
		<a href="{{ route('administrators/determinations/reports/edit', ['id' => $report->id]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
		{{ trans('reports.report_blocked') }}
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $report->determination->name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $report->name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>
		
		<textarea class="form-control" rows="10" disabled>{{ $report->report }}</textarea>
	</div>

@endsection


