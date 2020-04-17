@extends('default-template')

@section('title')
{{ trans('determinations.edit_determination') }}
@endsection 

@section('active_determinations', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('determinations/reports/create', [$determination->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('reports.create_report') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('determinations/show', [$determination->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>		
</ul>
@endsection

@section('content-title')
<i class="fas fa-edit"></i> {{ trans('determinations.edit_determination') }}
@endsection


@section('content')
<form method="post" action="{{ route('determinations/update', [$determination->id]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $nomenclator->name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.code') }} </span>
		</div>

		<input type="number" class="form-control" name="code" value="{{ $determination->code }}" required>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" value="{{ $determination->name }}" required>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.position') }} </span>
		</div>

		<input type="number" class="form-control" name="position" min="0" value="{{ $determination->position }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
		</div>
		<input type="number" class="form-control" name="biochemical_unit" min="0" step="0.01" value="{{ $determination->biochemical_unit }}">
	</div>

	<div class="mt-2 float-right">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


@section('extra-content')
<div class="card margins-boxs-tb">
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
							<a href="{{ route('determinations/reports/edit', [$report->id])}}" class="btn btn-info btn-sm" title="{{ trans('reports.edit_report') }}"> <i class="fas fa-edit fa-sm"></i> </a>
							<a href="" class="btn btn-info btn-sm" title="{{ trans('reports.destroy_report') }}"> <i class="fas fa-trash fa-sm"></i> </a>			
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection
