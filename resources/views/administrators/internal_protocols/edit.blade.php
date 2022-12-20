@extends('administrators/default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() 
	{
		$("#billing_period").val('{{ @old('billing_period_id') ?? $protocol->billing_period_id }}');
    });

    @if ($protocol->isOpen())
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

        $("input").removeAttr('disabled');
        $("select").removeAttr('disabled');
        $("textarea").removeAttr('disabled');

        $("#patientAutoComplete").attr('disabled', true);
    }
    
    function closeProtocol()
    {
        if (confirm("{{ trans('forms.confirm') }}")) 
        {
            $('#close_protocol').submit();
        }

        return false;
    }
    @else 
    function sendEmailProtocol() 
    {
        $('#send_email_protocol').submit();
    }
    @endif
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        @can('crud_practices')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/practices/index', ['internal_protocol_id' => $protocol->id]) }}"> {{ trans('practices.practices') }} </a>
        </li>
        @endcan

        @can('print_worksheets')
        <li class="nav-item">
            <a class="nav-link @if (! $protocol->isOpen()) disabled @endif" target="_blank" href="{{ route('administrators/protocols/generate_worksheet', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_worksheet') }} </a>
        </li>
        @endcan
        
        @can('print_protocols')
        <li class="nav-item">
            <a class="nav-link @if ($protocol->isOpen()) disabled @endif" target="_blank" href="{{ route('administrators/protocols/generate_protocol', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_protocol') }} </a>
        </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link @if ($protocol->isOpen()) disabled @endif" href="#" onclick="sendEmailProtocol()"> {{ trans('protocols.send_protocol_to_email') }} </a>

            <form method="post" action="{{ route('administrators/protocols/send_protocol_to_email', ['id' => $protocol->id]) }}" id="send_email_protocol">
                @csrf

                <input type="submit" class="d-none">
            </form>
        </li>

        @can('crud_patients')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/edit', ['id' => $protocol->internal_patient_id]) }}"> {{ trans('protocols.see_patient') }} </a>
        </li>
        @endcan

        @if ($protocol->isOpen())
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="closeProtocol()"> {{ trans('protocols.close_protocol') }} </a>

            <form method="post" action="{{ route('administrators/protocols/close', ['id' => $protocol->id]) }}" id="close_protocol">
                @csrf    
                
                <input class="d-none" type="submit">
            </form>
        </li>
        @endif
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Most of our work is done in this document. Try to fill in as many fields as possible to leave a clear clinical history. Once the protocol is closed, you can generate a pdf and it cannot be modified again for any reason.
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
    @if ($protocol->isOpen())
	<div id="securityMessage" class="alert alert-info fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-primary btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('protocols.protocol_blocked') }}
	</div>
    @else
    <div class="alert alert-warning fade show mt-3">
		{{ trans('protocols.protocol_closed_message') }}
	</div>    
    @endif
@endif

<form method="post" action="{{ route('administrators/protocols/update', ['id' => $protocol->id]) }}">
    @csrf
    {{ method_field('PUT') }}

    <div class="mt-3">
        <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="patientAutoComplete"> {{ trans('patients.patient') }} </label>
                <input type="text" class="form-control" id="patientAutoComplete" value="{{ $protocol->internalPatient->full_name }}" aria-describedby="patientHelp" disabled>

                <small id="patientHelp" class="form-text text-muted"> You cannot change the patient of a protocol once it has already been loaded </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="socialWorkAutoComplete"> {{ trans('social_works.social_work') }} </label>
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="@if (old('social_work_name')) {{ old('social_work_name') }} @else {{ $protocol->plan->social_work->name }} - {{ $protocol->plan->name }} @endif" aria-describedby="socialWorkHelp" required disabled>
                <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $protocol->plan_id }}">

                <small id="socialWorkHelp" class="form-text text-muted"> You can charge any social work even if it is not the one that the patient has charged </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="prescriberAutoComplete"> {{ trans('prescribers.prescriber') }} </label>
                <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') ?? $protocol->prescriber->full_name }}" aria-describedby="prescriberHelp" required disabled>
                <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') ?? $protocol->prescriber_id }}">

                <small id="prescriberHelp" class="form-text text-muted"> Associate a prescriber to the protocol to continue </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="completion_date"> {{ trans('protocols.completion_date') }} </label>
                <input type="date" class="form-control" name="completion_date" id="completion_date" value="{{ old('completion_date') ?? $protocol->completion_date }}" aria-describedby="completionDateHelp" disabled>
                
                <small id="completionDateHelp" class="form-text text-muted"> Indicates the date on which the practices were carried out. By this date the protocols are ordered </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="diagnostic"> {{ trans('protocols.diagnostic') }} </label>
                <input type="text" class="form-control" name="diagnostic" id="diagnostic" value="{{ old('diagnostic') ?? $protocol->diagnostic }}" aria-describedby="diagnosticHelp" disabled>
                
                <small id="diagnosticHelp" class="form-text text-muted"> Indicates the date on which the practices were carried out. By this date the protocols are ordered </small>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.billing_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="billing_period"> {{ trans('billing_periods.billing_period') }} </label>
                <select id="billing_period" class="form-select input-sm" name="billing_period_id" id="billing_period" aria-describedby="billingPeriodHelp" disabled>
                    <option value=""> {{ trans('forms.select_option') }}</option>

                    @foreach ($billing_periods as $billing_period)
                    <option value="{{ $billing_period->id }}">
                        {{ $billing_period->name }} [{{ date('d/m/Y', strtotime($billing_period->start_date)) }} - {{ date('d/m/Y', strtotime($billing_period->end_date)) }}]
                    </option>
                    @endforeach
                </select>

                <small id="billingPeriodHelp" class="form-text text-muted"> This field helps you to later perform the billing cut </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="quantity_orders"> {{ trans('protocols.quantity_orders') }} </label>
                <input type="number" class="form-control" name="quantity_orders" id="quantity_orders" min="0" value="{{ old('quantity_orders') ?? $protocol->quantity_orders }}" aria-describedby="quantityOrdersHelp" required disabled>

                <small id="quantityOrdersHelp" class="form-text text-muted"> This field helps you to later perform the billing cut </small>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="form-group mt-2">
            <h4><i class="fas fa-notes-medical"></i> <label for="observations"> {{ trans('protocols.observations') }} </label> </h4>
            <hr class="col-6">

            <textarea class="form-control" rows="3" name="observations" id="observations" aria-describedby="observationsHelp" disabled>{{ old('observations') ?? $protocol->observations }}</textarea>

            <small id="observationsHelp" class="form-text text-muted"> Any details about the process or the results of the analysis. These observations are public. </small>
        </div>
    </div>

    @if ($protocol->isOpen())
    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}" disabled>
    @endif
</form>
@endsection
