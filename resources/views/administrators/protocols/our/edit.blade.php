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

    @if (empty($protocol->closed))
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

        $("#submitButton").removeAttr('disabled');
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
            <a class="nav-link" href="{{ route('administrators/protocols/practices/create', ['protocol_id' => $protocol->id]) }}"> {{ trans('practices.practices') }} </a>
        </li>
        @endcan

        @can('print_worksheets')
        <li class="nav-item">
            <a class="nav-link @if (! empty($protocol->closed)) disabled @endif" target="_blank" href="{{ route('administrators/protocols/our/print_worksheet', ['id' => $protocol->id]) }}"> {{ trans('protocols.print_worksheet') }} </a>
        </li>
        @endcan
        
        @can('print_protocols')
        <li class="nav-item">
            <a class="nav-link @if (empty($protocol->closed)) disabled @endif" target="_blank" href="{{ route('administrators/protocols/our/print', ['id' => $protocol->id]) }}"> {{ trans('protocols.print_report') }} </a>
        </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link @if (empty($protocol->closed)) disabled @endif" href="#" onclick="sendEmailProtocol()"> {{ trans('protocols.send_protocol_to_email') }} </a>

            <form method="post" action="{{ route('administrators/protocols/our/send_protocol_to_email', ['id' => $protocol->id]) }}" id="send_email_protocol">
                @csrf

                <input type="submit" class="d-none">
            </form>
        </li>

        @can('crud_patients')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/edit', ['id' => $protocol->patient_id]) }}"> {{ trans('protocols.see_patient') }} </a>
        </li>
        @endcan

        @if (empty($protocol->closed))
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="closeProtocol()"> {{ trans('protocols.close_protocol') }} </a>

            <form method="post" action="{{ route('administrators/protocols/our/close', ['id' => $protocol->id]) }}" id="close_protocol">
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

@section('content')
@if (sizeof($errors) == 0)
    @if (empty($protocol->closed))
	<div id="securityMessage" class="alert alert-info fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
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

    <form method="post" action="{{ route('administrators/protocols/our/update', ['id' => $protocol->id]) }}">
        @csrf
        {{ method_field('PUT') }}

        <input type="hidden" name="type" value="our">
        
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
                    <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $protocol->plan->social_work->name }}" required readonly>
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

                    <select id="billing_period" class="form-select input-sm" name="billing_period_id" disabled>
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
                <h4><i class="fas fa-notes-medical"></i> {{ trans('protocols.observations') }} </h4>
                <hr class="col-6">

                <textarea class="form-control" rows="3" name="observations" readonly>{{ old('observations') ?? $protocol->observations }}</textarea>
            </div>
        </div>

        @if (empty($protocol->closed))
        <input type="submit" class="btn btn-lg btn-primary mt-3" id="submitButton" value="{{ trans('forms.save') }}" disabled>
        @endif
    </form>
@endsection
