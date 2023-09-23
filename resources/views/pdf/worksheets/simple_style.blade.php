@extends('pdf/base')

@section('title')
    {{ trans('protocols.worksheet_for_protocol') }} #{{ $protocol->id }}
@endsection

@section('style')
    <style>
        #first_column {
            position: absolute;
            top: 1%;
            width: 100px;
        }

        #second_column {
            margin-left: 17%;
        }

        .info {
            margin-bottom: 2%;
        }

        .info td {
            width: 100mm;
        }

        .page-break-after {
            page-break-after: always;
        }

        .page-break-before {
            page-break-before: always;
        }

        .page-break-inside {
            page-break-inside: avoid;
        }
    </style>
@endsection

@section('header')
    <table class="info">
        <tr>
            <td> {{ trans('patients.patient') }}: {{ $protocol->internalPatient->full_name }} </td>
            <td> {{ trans('protocols.protocol_number') }}: #{{ $protocol->id }} </td>
        </tr>

        <tr>
            <td> {{trans('patients.identification_number') }}: {{ $protocol->internalPatient->identification_number }} </td>

            <td> {{ trans('protocols.completion_date') }}: {{ \Carbon\Carbon::parse($protocol->completion_date)->format(Drops::getSystemParameterValueByKey('DATE_FORMAT')) }} </td>
        </tr>

        <tr>
            <td> {{ trans('patients.home_address') }}: {{ $protocol->internalPatient->address }} </td>

            <td>
                @php
                    $age = $protocol->internalPatient->age();
                    $format_type = $age != null && $age['year'] > 0;
                @endphp

                {{ trans('patients.age') }}: @if ($age != null) {{ trans_choice('patients.calculate_age', $format_type ? 1 : 0 , $protocol->internalPatient->age()) }} @endif
            </td>
         </tr>

        <tr>
            <td> {{ trans('prescribers.prescriber') }}: {{ $protocol->prescriber->full_name }} </td>
            <td>

                {{ trans('patients.sex') }}:
                @switch ($protocol->internalPatient->sex)
                    @case('M')
                        {{ trans('patients.male') }}
                        @break

                    @case('F')
                        {{ trans('patients.female') }}
                        @break

                    @default
                        {{ trans('patients.undefined') }}
                        @break
                @endswitch
            </td>
        </tr>

        <tr>
            <td> {{ trans('social_works.social_work') }}: {{ $protocol->plan->social_work->name }} </td>
            <td> {{ trans('patients.phone') }}: {{ $protocol->internalPatient->phone }} </td>
        </tr>
    </table>

    <table class="info">
        <tr>
            <td>
            @if (!empty($protocol->diagnostic))
                <div style="margin-bottom: 2%">
                    {{ trans('protocols.diagnostic') }}: {{ $protocol->diagnostic }}
                </div>
            @endif
            </td>

            <td>
                {!! DNS1D::getBarcodeHTML(str_pad($protocol->id, 12, "0", STR_PAD_LEFT), 'EAN13', 3, 50, 'black', 12) !!}
            </td>
        </tr>
    </table>

@endsection

@section('content')
    @foreach ($protocol->internalPractices as $practice)
            <div class="page-break-inside">
                {!! $practice->determination->worksheet_template !!} <br />
                ============================================ <br />
            </div>
    @endforeach
@endsection
