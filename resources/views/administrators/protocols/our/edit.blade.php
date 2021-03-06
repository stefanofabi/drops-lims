@extends('administrators/default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->protocol_id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a plan from list
        $("#plan").val('{{ @old('plan_id') ?? $protocol->plan_id }}');

        $('[data-toggle="tooltip"]').tooltip();
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
							url:   '{{ route("administrators/protocols/our/load_prescribers") }}',
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
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	@can('crud_practices')
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/protocols/our/add_practices', ['id' => $protocol->protocol_id]) }}">
			<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.add_practices') }}
		</a>
	</li>
	@endcan

    <li class="nav-item">
        <a class="nav-link" href="#">
            <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('billing_periods.edit_billing_period') }}
        </a>
    </li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/protocols/our/show', ['id' => $protocol->protocol_id]) }}">
			<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }}
		</a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->protocol_id }}
@endsection


@section('content')

<form method="post" action="{{ route('administrators/protocols/our/update', ['id' => $protocol->protocol_id]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->patient->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<select class="form-control input-sm" id="plan" name="plan_id">
				<option value=""> {{ trans('forms.select_option') }}</option>
					@foreach ($protocol->patient->affiliates as $affiliate)
						<option value="{{ $affiliate->plan_id }}">

							@if (!empty($affiliate->plan->social_work->expiration_date) && $affiliate->expiration_date < date('Y-m-d'))
								** {{ trans('social_works.expired_card')}} **
							@endif

							{{ $affiliate->plan->social_work->name }}  {{ $affiliate->plan->name }}

							@if (!empty($affiliate->affiliate_number))
								[{{ $affiliate->affiliate_number }}]
							@endif

						</option>
					@endforeach
		</select>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>

		<input type="hidden" id="prescriber_id" name="prescriber_id" value="{{ @old('prescriber_id') ?? $protocol->prescriber->id }}">
		<input type="text" class="form-control" id="prescriber" name="prescriber" value="{{ @old('prescriber') ?? $protocol->prescriber->full_name }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" name="completion_date" value="{{ @old('completion_date') ?? $protocol->protocol->completion_date }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
		</div>

		<input type="number" class="form-control" name="quantity_orders" value="{{ @old('quantity_orders') ?? $protocol->quantity_orders }}" min="0">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" name="diagnostic" value="{{ @old('diagnostic') ?? $protocol->diagnostic }}">
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.observations') }} </span>
		</div>

		<textarea class="form-control" rows="3" name="observations"> {{ @old('observations') ?? $protocol->protocol->observations }} </textarea>
	</div>

	<div class="mt-3 float-right">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>

</form>
@endsection


@section('extra-content')
@can('crud_practices')
	<div class="card mt-3 mb-4">
		<div class="card-header">
			<h4> <span class="fas fa-syringe" ></span> {{ trans('protocols.practices')}} </h4>
	    </div>

	    <div class="table-responsive">
			<table class="table table-striped">
					<tr class="info">
						<th> {{ trans('determinations.code') }} </th>
						<th> {{ trans('determinations.determination') }} </th>
						<th> {{ trans('determinations.amount') }} </th>
						<th> {{ trans('protocols.informed') }} </th>
						<th> {{ trans('protocols.signed_off') }} </th>
						<th class="text-right"> {{ trans('forms.actions') }}</th>
					</tr>

					@php
						$total_amount = 0;
					@endphp

					@foreach ($protocol->protocol->practices as $practice)

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
							<td>
								@forelse($practice->signs as $sign)
								    <a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
										<img height="30px" width="30px" src="{{ asset('storage/avatars/'.$sign->user->avatar) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
									</a>
								@empty
								    {{ trans('protocols.not_signed')}}
								@endforelse
							</td>
							<td class="text-right">
									<a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_practice') }}"> <i class="fas fa-edit fa-sm"></i> </a>

									<a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_practice') }}"> <i class="fas fa-trash fa-sm"></i> </a>
							</td>
						</tr>
					@endforeach

					<tr>
						<td colspan="6" class="text-right">
							<h4> Total: $ {{ number_format($total_amount, 2, ",", ".") }} </h4>
						</td>
					</tr>
			</table>
		</div>
	</div>
@endcan
@endsection
