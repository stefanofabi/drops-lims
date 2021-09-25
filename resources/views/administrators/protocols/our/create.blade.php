@extends('administrators/default-template')

@section('title')
    {{ trans('protocols.create_protocol') }}
@endsection

@section('active_protocols', 'active')

@section('js')

    <script type="text/javascript">

        var token = $('meta[name="csrf-token"]').attr('content');

        $(function () {
            $("#patient").autocomplete({
                minLength: 2,
                source: function (event, ui) {
                    var parameters = {
                        "filter": $("#patient").val()
                    };

                    $.ajax({
                        data: parameters,
                        url: '{{ route("administrators/protocols/our/load_patients") }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {
                            //$("#resultados").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
                        },
                        success: ui
                    });

                    return ui;
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $('#patient').val(ui.item.label);
                    $('#patient_id').val(ui.item.id);

                    redirect_by_post('{{ route("administrators/protocols/our/create") }}', {
                        patient_id: ui.item.id,
                        '_token': token
                    }, false);
                }
            });
        });


        $(function () {
            $("#prescriber").autocomplete({
                minLength: 2,
                source: function (event, ui) {
                    var parameters = {
                        "filter": $("#prescriber").val()
                    };

                    $.ajax({
                        data: parameters,
                        url: '{{ route("administrators/protocols/our/load_prescribers") }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {
                            //$("#resultados").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
                        },
                        success: ui
                    });

                    return ui;
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $('#prescriber').val(ui.item.label);
                    $('#prescriber_id').val(ui.item.id);
                }
            });
        });

        /* function to redirect a webpage to another using post method */
        function redirect_by_post(purl, pparameters, in_new_tab) {
            pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
            in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;

            var form = document.createElement("form");
            $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
            if (in_new_tab) {
                $(form).attr("target", "_blank");
            }
            $.each(pparameters, function (key) {
                $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
            });
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            return false;
        }

        $(document).ready(function () {
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

    @if (!empty($patient) && $patient->affiliates->isEmpty())
        <div class="alert alert-warning">
            <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.unloaded_social_work') }}
        </div>
    @else
        <div class="alert alert-info">
            <strong>{{ trans('forms.information') }}!</strong> {{ trans('protocols.create_notice') }}
        </div>
    @endif

    <form method="post" action="{{ route('administrators/protocols/our/store') }}">
        @csrf

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.patient') }} </span>
            </div>

            <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient->id ?? '' }}">
            <input type="text" class="form-control" id="patient" value="{{ $patient->full_name ?? '' }}"
                   placeholder="{{ trans('forms.start_typing') }}" required>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
            </div>

            <select class="form-select input-sm" name="plan_id" required>
                <option value=""> {{ trans('forms.select_option') }}</option>

                @if(isset($patient->affiliates))
                    @foreach ($patient->affiliates as $affiliate)
                        <option value="{{ $affiliate->plan_id }}">
                            @if (!empty($affiliate->expiration_date) && $affiliate->expiration_date < date('Y-m-d'))
                                ** {{ trans('social_works.expired_card')}} **
                            @endif

                            {{ $affiliate->plan->social_work->name }}  {{ $affiliate->plan->name }}

                            @if (!empty($affiliate->affiliate_number))
                                [{{ $affiliate->affiliate_number }}]
                            @endif

                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
            </div>

            <input type="hidden" id="prescriber_id" name="prescriber_id">
            <input type="text" class="form-control" id="prescriber" placeholder="{{ trans('forms.start_typing') }}"
                   required>
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
                <span class="input-group-text"> {{ trans('protocols.observations') }} </span>
            </div>

            <textarea class="form-control" rows="3" name="observations"></textarea>
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

        <div class="mt-3 float-right">
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </form>
@endsection