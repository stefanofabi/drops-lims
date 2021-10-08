@extends('administrators/default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() 
	{
        // Select a plan from list
        $("#plan").val('{{ @old('plan_id') ?? $protocol->plan_id }}');
		$("#billing_period").val('{{ @old('billing_period_id') ?? $protocol->billing_period_id }}');

        $('[data-toggle="tooltip"]').tooltip();
    });


	$(function () {
        $("#socialWorkAutoComplete").autocomplete({
            minLength: 2,
            source: function (event, ui) {
                var parameters = {
                    "filter": $("#socialWorkAutoComplete").val()
                };

                $.ajax({
                    data: parameters,
                    url: '{{ route("administrators/settings/social_works/getSocialWorks") }}',
                    type: 'post',
                    dataType: 'json',
                    success: ui
                });

                return ui;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#plan').val(ui.item.plan_id);
                $('#socialWorkAutoComplete').val(ui.item.label);
            }
        });
    });

    $(function () {
        $("#prescriberAutoComplete").autocomplete({
            minLength: 2,
            source: function (event, ui) {
                var parameters = {
                    "filter": $("#prescriberAutoComplete").val()
                };

                $.ajax({
                    data: parameters,
                    url: '{{ route("administrators/prescribers/load_prescribers") }}',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        //$("#ajaxResults").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
                    },
                    success: ui
                });

                return ui;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#prescriberAutoComplete').val(ui.item.label);
                $('#prescriber').val(ui.item.id);
            }
        });
    });

    function enableSubmitForm() 
    {
        $('#securityMessage').hide('slow');

        $("input").removeAttr('readonly');
        $("select").removeAttr('disabled');
        $("textarea").removeAttr('readonly');

        $("#submitButtonVisible").removeClass('disabled');

        enableForm = true;
    }

    function submitForm() 
    {
        if (enableForm) 
        {
            let submitButton = $('#submit-button');
            submitButton.click();
        }
    }
</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
    @can('crud_practices')
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/protocols/our/add_practices', ['id' => $protocol->id]) }}">
			<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.add_practices') }}
		</a>
	</li>
	@endcan

    @can('print_worksheets')
		<li class="nav-item">
			<a class="nav-link" target="_blank" href="{{ route('administrators/protocols/our/print_worksheet', ['id' => $protocol->id]) }}">
				<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_worksheet') }}
			</a>
		</li>
	@endcan

	@can('print_protocols')
		<li class="nav-item">
			<a class="nav-link" target="_blank" href="{{ route('administrators/protocols/our/print', ['id' => $protocol->id]) }}">
				<img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_report') }}
			</a>
		</li>
	@endcan

	@can('crud_patients')
	    <li class="nav-item">
	        <a class="nav-link" href="{{ route('administrators/patients/edit', ['id' => $protocol->patient_id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.see_patient') }} </a>
	    </li>
	@endcan
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('prescribers.prescriber_blocked') }}
	</div>
@endif

    <form method="post" action="{{ route('administrators/protocols/our/update', ['id' => $protocol->id]) }}">
        @csrf
        {{ method_field('PUT') }}
        
        <div class="col-10">
            <div class="mt-3">
                <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
                <hr class="col-6">
                
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.patient') }} </span>
                    </div>

                    <input type="hidden" name="patient_id" value="{{ $protocol->patient_id }}">
                    <input type="text" class="form-control" id="patientAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $protocol->patient->full_name }}" required disabled>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
                    </div>

                    <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $protocol->plan_id }}">
                    <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $protocol->plan->social_work->name ?? '' }}" required readonly>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
                    </div>

                    <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') ?? $protocol->prescriber_id }}">
                    <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') ?? $protocol->prescriber->full_name ?? '' }}" readonly>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
                    </div>

                    <input type="date" class="form-control" name="completion_date" value="{{ old('completion_date') ?? $protocol->completion_date }}" readonly>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
                    </div>

                    <input type="text" class="form-control" name="diagnostic" value="{{ old('diagnostic') ?? $protocol->diagnostic }}" readonly>
                </div>
            </div>
            
            <div class="mt-3">
                <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.billing_data') }} </h4>
                <hr class="col-6">

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
                    </div>

                    <input type="number" class="form-control" name="quantity_orders" min="0" value="{{ old('quantity_orders') ?? $protocol->quantity_orders }}" required readonly>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('billing_periods.billing_period') }} </span>
                    </div>

                    <select id="billing_period" class="form-select input-sm" name="billing_period_id" required disabled>
                        <option value=""> {{ trans('forms.select_option') }}</option>

                        @foreach ($billing_periods as $billing_period)
                            <option value="{{ $billing_period->id }}">
                                {{ $billing_period->name }} [{{ date('d/m/Y', strtotime($billing_period->start_date)) }} - {{ date('d/m/Y', strtotime($billing_period->end_date)) }}]
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-5">
                <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.observations') }} </h4>
                <hr class="col-6">

                <textarea class="form-control" rows="3" name="observations" readonly>{{ old('observations') ?? $protocol->observations }}</textarea>
            </div>
        </div>

        <input type="submit" class="d-none" id="submit-button">
    </form>
@endsection


@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary disabled" id="submitButtonVisible" onclick="submitForm()">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
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
						<th class="text-end"> {{ trans('forms.actions') }}</th>
					</tr>

					@php
						$total_amount = 0;
					@endphp

					@foreach ($protocol->practices as $practice)

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
							<td class="text-end">
									<a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_practice') }}"> <i class="fas fa-edit fa-sm"></i> </a>

									<a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_practice') }}"> <i class="fas fa-trash fa-sm"></i> </a>
							</td>
						</tr>
					@endforeach

					<tr>
						<td colspan="6" class="text-end">
							<h4> Total: ${{ number_format($total_amount, 2, ",", ".") }} </h4>
						</td>
					</tr>
			</table>
		</div>
	</div>
@endcan
@endsection
