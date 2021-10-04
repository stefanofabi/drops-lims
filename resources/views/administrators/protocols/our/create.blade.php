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

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('protocols.create_protocol') }}
@endsection


@section('content')

    @if (!empty($patient) && empty($patient->social_work_id))
        <div class="alert alert-warning">
            <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.unloaded_social_work') }}
        </div>
    @else
        <div class="alert alert-info">
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
            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('patients.patient') }} </span>
                </div>

                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                <input type="text" class="form-control" id="patientAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $patient->full_name ?? '' }}" required>
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
                </div>

                <input type="hidden" name="plan_id" id="plan" value="{{ $patient->plan_id ?? '' }}">
                <input type="text" class="form-control" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $patient->plan->social_work->name ?? '' }}" required>
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
                </div>

                <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') }}">
                <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') }}" required>
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
                </div>

                <input type="date" class="form-control" name="completion_date" value="{{ date('Y-m-d') }}">
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
                </div>

                <input type="number" class="form-control" name="quantity_orders" min="0" value="0" required>
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
                </div>

                <input type="text" class="form-control" name="diagnostic">
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.billing_period') }} </span>
                </div>

                <select id="billing_period" class="form-control input-sm" name="billing_period_id" required>
                    <option value=""> {{ trans('forms.select_option') }}</option>

                    @foreach ($billing_periods as $billing_period)
                        <option value="{{ $billing_period->id }}">
                            {{ $billing_period->name }} [{{ date('d-m-Y', strtotime($billing_period->start_date)) }} - {{ date('d-m-Y', strtotime($billing_period->end_date)) }}]
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mt-2 mb-1 col-md-9 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('protocols.observations') }} </span>
                </div>

                <textarea class="form-control" rows="3" name="observations"></textarea>
            </div>
        </div>
        <input type="submit" style="display: none" id="submit-button">
    </form>
@endsection

@section('content-footer')
<div class="float-end">
    <button type="submit" class="btn btn-primary" onclick="submitForm()">
        <span class="fas fa-save"></span> {{ trans('forms.save') }}
    </button>
</div>
@endsection