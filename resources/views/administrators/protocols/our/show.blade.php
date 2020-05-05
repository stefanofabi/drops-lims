@extends('administrators/default-template')

@section('title')
{{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" target="_blank" href="{{ route('administrators/protocols/our/print_worksheet', $protocol->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_worksheet') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" target="_blank" href="{{ route('administrators/protocols/our/print', $protocol->id) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_report') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')
	<div class="alert alert-info fade show">
		<a href="{{ route('administrators/protocols/our/edit', $protocol->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
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
<div class="card mt-3 mb-4">
	<div class="card-header">
		<h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

    <div class="table-responsive">
		<table class="table table-striped">
				<tr class="info">
					<th> {{ trans('determinations.code') }} </th>
					<th> {{ trans('determinations.determination') }} </th>	
					<th> {{ trans('determinations.amount') }} </th>
					<th> {{ trans('determinations.informed') }} </th>	
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

				@php 
					$total_amount = 0;
				@endphp

				@foreach ($practices as $practice)

					@php
						$total_amount += $practice->amount;
					@endphp
					<tr>
						<td> {{ $practice->report->determination->code }} </td>
						<td> {{ $practice->report->determination->name }} </td>
						<td> $ {{ number_format($practice->amount, 2, ",", ".") }} </td>
						<td> 
							@if (empty($practice->results->first()))
								<span class="badge badge-primary"> {{ trans('forms.no') }} </span>
							@else 
								<span class="badge badge-success"> {{ trans('forms.yes') }} </span>
							@endif
						</td>
						<td class="text-right">
							<a href="{{ route('administrators/protocols/practices/show', $practice->id) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>	
						</td>
					</tr>
				@endforeach

				<tr>
					<td colspan="5" class="text-right">
						<h4> Total: $ {{ number_format($total_amount, 2, ",", ".") }} </h4>
					</td>
				</tr>
		</table>
	</div>
</div>
@endsection

