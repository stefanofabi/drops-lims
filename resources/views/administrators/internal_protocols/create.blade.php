@extends('administrators/default-template')

@section('title')
    {{ trans('protocols.create_protocol') }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">
        $(function () {
            $("#patientAutoComplete").autocomplete({
                minLength: 2,
                source: function (event, ui) {
                    var parameters = {
                        "filter": $("#patientAutoComplete").val()
                    };

                    $.ajax({
                        data: parameters,
                        url: '{{ route("administrators/patients/load_patients") }}',
                        type: 'post',
                        dataType: 'json',
                        success: ui
                    });

                    return ui;
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $('#patient').val(ui.item.id);

                    $('#submitPatient').click();
                }
            });
        });

        $(function () 
        {
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

        $(document).ready(function () 
        {
            // Select a billing period from list
            $("#billing_period").val("{{ $current_billing_period->id ?? '' }}");
        });
    </script>
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('protocols.create_protocol') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
To create a protocol you have to select at least the patient, the social work and the prescriber. Then you can load the practices that you are going to perform on the patient.
</p>
@endsection

@section('content')
@if (!empty($patient))
    @if (empty($patient->plan_id))
    <div class="alert alert-warning mt-3">
        <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.unloaded_social_work') }}
    </div>
    @elseif ($patient->expiration_date < date('Y-m-d'))
    <div class="alert alert-warning mt-3">
        <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.expired_social_work') }}
    </div>
    @endif
@else
<div class="alert alert-info mt-3">
    <strong>{{ trans('forms.information') }}!</strong> {{ trans('protocols.create_notice') }}
</div>
@endif

<form action="{{ route('administrators/protocols/create') }}">
    <input type="hidden" name="internal_patient_id" id="patient">

    <input type="submit" class="d-none" id="submitPatient">
</form>

<form method="post" action="{{ route('administrators/protocols/store') }}">
    @csrf

    <div>
        <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="patientAutoComplete"> {{ trans('patients.patient') }} </label>
                <input type="text" class="form-control" id="patientAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="@if ($patient) {{ $patient->last_name ?? '' }} {{ $patient->name ?? '' }} @endif" aria-describedby="patientHelp" required>
                <input type="hidden" name="internal_patient_id" value="{{ $patient->id ?? '' }}">

                <small id="patientHelp" class="form-text text-muted"> When selecting a patient we will automatically load their social work </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="socialWorkAutoComplete"> {{ trans('social_works.social_work') }} </label>
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $patient->plan->social_work->name ?? '' }}" aria-describedby="socialWorkHelp" required>
                <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $patient->plan_id ?? '' }}">

                <small id="socialWorkHelp" class="form-text text-muted"> You can charge any social work even if it is not the one that the patient has charged </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="prescriberAutoComplete"> {{ trans('prescribers.prescriber') }} </label>
                <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') }}" aria-describedby="prescriberHelp" required>
                <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') }}">

                <small id="prescriberHelp" class="form-text text-muted"> Associate a prescriber to the protocol to continue </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="completion_date"> {{ trans('protocols.completion_date') }} </label>
                <input type="date" class="form-control" name="completion_date" id="completion_date" value="{{ old('completion_date') ?? date('Y-m-d') }}" aria-describedby="completionDateHelp">
                    
                <small id="completionDateHelp" class="form-text text-muted"> Indicates the date on which the practices were carried out. By this date the protocols are ordered </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="diagnostic"> {{ trans('protocols.diagnostic') }} </label>
                <input type="text" class="form-control" name="diagnostic" id="diagnostic" value="{{ old('diagnostic') }}" aria-describedby="diagnosticHelp">

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
                <label for="quantity_orders"> {{ trans('billing_periods.billing_period') }} </label>
                <select id="billing_period" class="form-select input-sm" name="billing_period_id">
                    <option value=""> {{ trans('forms.select_option') }}</option>

                    @foreach ($billing_periods as $billing_period)
                    <option value="{{ $billing_period->id }}">
                        {{ $billing_period->name }} [{{ date('d-m-Y', strtotime($billing_period->start_date)) }} - {{ date('d-m-Y', strtotime($billing_period->end_date)) }}]
                    </option>
                    @endforeach
                </select>

                <small id="quantityOrdersHelp" class="form-text text-muted"> This field helps you to later perform the billing cut </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="quantity_orders"> {{ trans('protocols.quantity_orders') }} </label>
                <input type="number" class="form-control" name="quantity_orders" id="quantity_orders" min="0" value="{{ old('quantity_orders') ?? '1' }}" aria-describedby="quantityOrdersHelp" required>

                <small id="quantityOrdersHelp" class="form-text text-muted"> This field helps you to later perform the billing cut </small>
            </div>
        </div>
    </div>
        
    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection