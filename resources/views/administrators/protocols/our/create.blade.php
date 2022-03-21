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
                        beforeSend: function () {
                            //$("#ajaxResults").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
                        },
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

        function submitForm() 
        {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

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

@section('content')

    @if (!empty($patient) && empty($patient->plan_id))
        <div class="alert alert-warning mt-3">
            <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.unloaded_social_work') }}
        </div>
    @else
        <div class="alert alert-info mt-3">
            <strong>{{ trans('forms.information') }}!</strong> {{ trans('protocols.create_notice') }}
        </div>
    @endif

    <form action="{{ route('administrators/protocols/our/create') }}">
        <input type="hidden" name="patient_id" id="patient">

        <input type="submit" class="d-none" id="submitPatient">
    </form>

    <form method="post" action="{{ route('administrators/protocols/our/store') }}">
        @csrf
        
        <div class="col-10">
            <div class="mt-3">
                <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
                <hr class="col-6">
                
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.patient') }} </span>
                    </div>

                    <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                    <input type="text" class="form-control" id="patientAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $patient->full_name ?? '' }}" required>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
                    </div>

                    <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $patient->plan_id ?? '' }}">
                    <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $patient->plan->social_work->name ?? '' }}" required>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
                    </div>

                    <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') }}">
                    <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') }}">
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
                    </div>

                    <input type="date" class="form-control" name="completion_date" value="{{ old('completion_date') ?? date('Y-m-d') }}">
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
                    </div>

                    <input type="text" class="form-control" name="diagnostic" value="{{ old('diagnostic') }}">
                </div>
            </div>
            
            <div class="mt-3">
                <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.billing_data') }} </h4>
                <hr class="col-6">

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
                    </div>

                    <input type="number" class="form-control" name="quantity_orders" min="0" value="{{ old('quantity_orders') ?? '1' }}" required>
                </div>

                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('billing_periods.billing_period') }} </span>
                    </div>

                    <select id="billing_period" class="form-select input-sm" name="billing_period_id">
                        <option value=""> {{ trans('forms.select_option') }}</option>

                        @foreach ($billing_periods as $billing_period)
                            <option value="{{ $billing_period->id }}">
                                {{ $billing_period->name }} [{{ date('d-m-Y', strtotime($billing_period->start_date)) }} - {{ date('d-m-Y', strtotime($billing_period->end_date)) }}]
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-5">
                <h4><i class="fas fa-notes-medical"></i> {{ trans('protocols.observations') }} </h4>
                <hr class="col-6">

                <textarea class="form-control" rows="3" name="observations">{{ old('observations') }}</textarea>
            </div>
        </div>
        
        <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
    </form>
@endsection