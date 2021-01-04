@extends('pdf/base')

@section('title')
    {{ trans('protocols.worksheet_for_protocol') }} #{{ $our_protocol->protocol_id }}
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
            <td> {{ trans('patients.patient') }}: {{ $our_protocol->patient->full_name }} </td>
            <td> {{ trans('protocols.protocol_number') }}: #{{ $our_protocol->protocol_id }} </td>
        </tr>

        <tr>
            <td> {{trans('patients.dni') }}: {{ $our_protocol->patient->key }} </td>

            <td> {{ trans('protocols.completion_date') }}: @if ($our_protocol->protocol->completion_date) {{ date_format(new DateTime($our_protocol->protocol->completion_date), 'd/m/Y') }} @endif </td>
        </tr>

        <tr>
            <td> {{ trans('patients.home_address') }}: {{ $our_protocol->patient->address }} </td>

            <td>
                @php
                    $age = $our_protocol->patient->age();
                    $format_type = $age != null && $age['year'] > 0;
                @endphp

                {{ trans('patients.age') }}: @if ($age != null) {{ trans_choice('patients.calculate_age', true ? 1 : 0 , $our_protocol->patient->age()) }} @endif
            </td>
         </tr>

        <tr>
            <td> {{ trans('prescribers.prescriber') }}: {{ $our_protocol->prescriber->full_name }} </td>
            <td>

                {{ trans('patients.sex') }}:
                @switch ($our_protocol->patient->sex)
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
            <td> {{ trans('social_works.social_work') }}: {{ $our_protocol->plan->social_work->name }} </td>
            <td>
                {{ trans('phones.phone') }}:

                @if ($our_protocol->patient->phones->isNotEmpty())
                     {{ $our_protocol->patient->phones->first()->phone }}
                @endif
            </td>
        </tr>
    </table>


    @if (!empty($our_protocol->diagnostic))
        <div style="margin-bottom: 2%">
            {{ trans('protocols.diagnostic') }}: {{ $our_protocol->diagnostic }}
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
