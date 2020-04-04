@extends('default-template')

@section('title')
{{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/add_practices', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_worksheet') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/add_practices', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_report') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')
	<div class="alert alert-info fade show">
		<a href="{{ route('protocols/our/edit', [$protocol->id]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
		{{ trans('protocols.protocol_blocked') }}
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $patient->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $social_work->name }} {{ $plan->name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>
		
		<input type="text" class="form-control" value="{{ $prescriber->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" value="{{ $protocol->completion_date }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
		</div>

		<input type="number" class="form-control" value="{{ $protocol->quantity_orders }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->diagnostic }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.observations') }} </span>
		</div>

		<textarea class="form-control" rows="3" disabled>{{ $protocol->observations }}</textarea>
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
						<td> {{ $practice->report->determination->code }} </td>
						<td> {{ $practice->report->determination->name }} </td>
						<td> N/A </td>
						<td class="text-right">
							<a href="" class="btn btn-info btn-sm" title="{{ trans('protocols.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>			
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection

