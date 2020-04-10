@extends('default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a plan from list
        $("#plan").val('{{ $plan->id }}');
    });

	$(function() {
		$("#prescriber").autocomplete({
			minLength: 2,
			source: function(event, ui) {
						var parameters = {
							"filter" : $("#prescriber").val()
						};

						$.ajax({
							data:  parameters,
							url:   '{{ route("protocols/our/load_prescribers") }}',
							type:  'post',
							dataType: 'json',
							beforeSend: function () {
										//$("#resultados").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
									},
							success:  ui
						});
						
						return ui;
					},
			select: function(event, ui) {
						event.preventDefault();
						$('#prescriber').val(ui.item.label);
						$('#prescriber_id').val(ui.item.id);
					}
		});
	});

</script>
@endsection

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/add_practices', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.add_practices') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/show', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

<form method="post" action="{{ route('protocols/our/update', [$protocol->id]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $patient->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<select class="form-control input-sm" id="plan" name="plan_id">
				<option value=""> {{ trans('forms.select_option') }}</option>
					@foreach ($social_works as $social_work)
						<option value="{{ $social_work->plan_id }}"> 

							@if (!empty($social_work->expiration_date) && $social_work->expiration_date < date('Y-m-d'))
								** {{ trans('social_works.expired_card')}} **
							@endif

							{{ $social_work->name }}  {{ $social_work->plan }}

							@if (!empty($social_work->affiliate_number)) 
								[{{ $social_work->affiliate_number }}]
							@endif

						</option>
					@endforeach
		</select>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>
		
		<input type="hidden" id="prescriber_id" name="prescriber_id" value="{{ $prescriber->id }}">
		<input type="text" class="form-control" id="prescriber" value="{{ $prescriber->full_name }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" name="completion_date" value="{{ $protocol->completion_date }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
		</div>

		<input type="number" class="form-control" name="quantity_orders" value="{{ $protocol->quantity_orders }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" name="diagnostic" value="{{ $protocol->diagnostic }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.observations') }} </span>
		</div>

		<textarea class="form-control" rows="3" name="observations"> {{ $protocol->observations }} </textarea>
	</div>

	<div class="mt-3 float-right">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	

</form>
@endsection


@section('extra-content')
<div class="card mt-3">
	<div class="card-header">
		<h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

    <div class="table-responsive">
		<table class="table table-striped">
				<tr  class="info">
					<th> {{ trans('determinations.code') }} </th>
					<th> {{ trans('determinations.determination') }} </th>	
					<th> {{ trans('determinations.amount') }} </th>
					<th> {{ trans('determinations.informed') }} </th>	
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

				@foreach ($practices as $practice)
					<tr>
						<td> {{ $practice->report->determination->code }} </td>
						<td> {{ $practice->report->determination->name }} </td>
						<td> $ {{ $practice->amount }} </td>
						<td> N/A </td>
						<td class="text-right">
							<a href="{{ route('protocols/practices/edit', [$practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_practice') }}"> <i class="fas fa-edit fa-sm"></i> </a>		
							<a href="{{ route('protocols/practices/destroy', [$practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_practice') }}"> <i class="fas fa-trash fa-sm"></i> </a>		
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection
