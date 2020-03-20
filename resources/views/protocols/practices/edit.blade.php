@extends('default-template')

@section('title')
{{ trans('protocols.edit_protocol') }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {

    });

</script>
@endsection

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/edit', [$practice->protocol_id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $determination['name'] }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>
		
		<input type="text" class="form-control" value="{{ $report->name }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->diagnostic }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.observations') }} </span>
		</div>

		<textarea class="form-control" rows="3"> {{ $protocol->observations }} </textarea>
	</div>

@endsection	

@section('extra-content')
<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

    <div class="table-responsive">
		<table class="table table-striped">
				<tr  class="info">
					<th> {{ trans('determinations.code') }} </th>
					<th> {{ trans('determinations.determination') }} </th>	
					<th> {{ trans('determinations.informed') }} </th>	
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

				@foreach ($practices as $practice)
					<tr>
						<td> {{ $practice->code }} </td>
						<td> {{ $practice->name }} </td>
						<td> N/A </td>
						<td class="text-right">
							<a href="{{ route('protocols/practices/edit', [$practice->id]) }}" class="btn btn-info btn-sm" title=""> <i class="fas fa-edit fa-sm"></i> </a>			
							<a href="#" class="btn btn-info btn-sm" title="" onclick=""> <i class="fas fa-trash fa-sm"></i> </a>
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection

