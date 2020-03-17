@extends('default-template')

@section('title')
{{ trans('determinations.show_report') }}
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
<i class="fas fa-file-pdf"></i> {{ trans('determinations.show_report') }}
@endsection


@section('content')
	<div class="alert alert-info fade show">
		<a href="{{ route('determinations/reports/edit', [$report->id]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
		{{ trans('determinations.report_blocked') }}
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $determination->name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $report->name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.report') }} </span>
		</div>

		<textarea class="form-control" rows="10" disabled> {{ $report->report }} </textarea>
	</div>

@endsection	


