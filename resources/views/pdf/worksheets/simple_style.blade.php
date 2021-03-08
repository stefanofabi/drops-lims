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
            <td> {{ trans('patients.patient') }}: {{ $protocol->patient->full_name }} </td>
            <td> {{ trans('protocols.protocol_number') }}: #{{ $protocol->id }} </td>
        </tr>

        <tr>
            <td> {{trans('patients.dni') }}: {{ $protocol->patient->key }} </td>

            <td> {{ trans('protocols.completion_date') }}: @if ($protocol->completion_date) {{ date_format(new DateTime($protocol->completion_date), 'd/m/Y') }} @endif </td>
        </tr>

        <tr>
            <td> {{ trans('patients.home_address') }}: {{ $protocol->patient->address }} </td>

            <td>
                @php
                    $age = $protocol->patient->age();
                    $format_type = $age != null && $age['year'] > 0;
                @endphp

                {{ trans('patients.age') }}: @if ($age != null) {{ trans_choice('patients.calculate_age', true ? 1 : 0 , $protocol->patient->age()) }} @endif
            </td>
         </tr>

        <tr>
            <td> {{ trans('prescribers.prescriber') }}: {{ $protocol->prescriber->full_name }} </td>
            <td>

                {{ trans('patients.sex') }}:
                @switch ($protocol->patient->sex)
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
            <td>
                {{ trans('phones.phone') }}:

                @if ($protocol->patient->phones->isNotEmpty())
                     {{ $protocol->patient->phones->first()->phone }}
                @endif
            </td>
        </tr>
    </table>


    @if (!empty($protocol->diagnostic))
        <div style="margin-bottom: 2%">
            {{ trans('protocols.diagnostic') }}: {{ $protocol->diagnostic }}
        </div>
    @endif

@endsection

@section('body')
    @foreach ($practices as $practice)
            <div class="page-break-inside">
                {{ $practice->report->determination->name }} - {{ $practice->report->name }} <br />
                ============================================ <br />
            </div>
    @endforeach
@endsection
