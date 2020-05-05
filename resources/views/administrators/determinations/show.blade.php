@extends('administrators/default-template')

@section('title')
{{ trans('determinations.show_determination') }}
@endsection 

@section('active_determinations', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
<i class="fas fa-eye"></i> {{ trans('determinations.show_determination') }}
@endsection


@section('content')
<div class="alert alert-info fade show">
	<a href="{{ route('administrators/determinations/edit', $determination->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('determinations.determination_blocked') }}
</div>

<div class="input-group mt-2 col-md-9 input-form">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
	</div>

	<input type="text" class="form-control" value="{{ $nomenclator->name }}" disabled>
</div>

<div class="input-group mt-2 col-md-9 input-form">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.code') }} </span>
	</div>

	<input type="number" class="form-control" value="{{ $determination->code }}" disabled>
</div>

<div class="input-group mt-2 col-md-9 input-form">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.name') }} </span>
	</div>

	<input type="text" class="form-control" value="{{ $determination->name }}" disabled>
</div>

<div class="input-group mt-2 col-md-9 input-form">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.position') }} </span>
	</div>

	<input type="number" class="form-control" value="{{ $determination->position }}" disabled>
</div>

<div class="input-group mt-2 col-md-9 input-form">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
	</div>
	<input type="number" class="form-control" value="{{ $determination->biochemical_unit }}" disabled>
</div>

@endsection	


@section('extra-content')
<div class="card mt-3 mb-3">
	<div class="card-header">
		<h4> <span class="fas fa-file-alt" ></span> {{ trans('reports.index_reports')}} </h4>
    </div>


    <div class="table-responsive">
		<table class="table table-striped">
				<tr  class="info">
					<th> {{ trans('reports.name') }} </th>
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

				@foreach ($reports as $report)
					<tr>
						<td> {{ $report->name }} </td>
						<td class="text-right">
							<a href="{{ route('administrators/determinations/reports/show', [$report->id]) }}" class="btn btn-info btn-sm" title="{{ trans('reports.show_report') }}"> <i class="fas fa-eye fa-sm"></i> </a>
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection

