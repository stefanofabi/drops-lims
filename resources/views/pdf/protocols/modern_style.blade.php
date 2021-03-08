@extends('pdf/base')

@section('title')
    {{ trans('protocols.protocol_number') }} #{{ $protocol->id }}
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

        .cover {
            background: #FFFFA6;
        / / margin-left: 20 px;
        }


        .cover td {
            width: 150mm;
        }

        .info {
            margin-top: 2%;
            margin-bottom: 2%;
            margin-left: 50px
        }

        .info td {
            text-align: left;
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
    <div id="first_column">
        <img width="100" height="100" src="{{ asset('images/logo.png') }}">
    </div>

    <div id="second_column">
        <table class="cover">
            <tr>
                <td class="title"> Title 1</td>
            </tr>
        </table>

        <br/>

        <table class="cover">
            <tr>
                <td> Text 1</td>
            </tr>

            <tr>
                <td> Text 2</td>
            </tr>

            <tr>
                <td> Text 3</td>
            </tr>
        </table>
    </div>

    <table class="info">
        <tr>
            <td> {{ trans('patients.patient') }}: {{ $protocol->patient->full_name  }} </td>
            <td> {{ trans('protocols.protocol_number') }}: #{{ $protocol->id }} </td>
        </tr>

        <tr>
            <td> {{ trans('patients.home_address') }}: {{ $protocol->patient->address }} </td>
            <td>  {{ trans('protocols.completion_date') }}: @if ($protocol->completion_date) {{ date_format(new DateTime($protocol->completion_date), 'd/m/Y') }} @endif </td>
        </tr>

        <tr>
            <td> {{ trans('prescribers.prescriber') }}: {{ $protocol->prescriber->full_name }} </td>
            <td>
                @php
                    $age = $protocol->patient->age();
                    $format_type = $age != null && $age['year'] > 0;
                @endphp

                {{ trans('patients.age') }}: @if ($age != null) {{ trans_choice('patients.calculate_age', true ? 1 : 0 , $protocol->patient->age()) }} @endif
            </td>
        </tr>

        <tr>
            <td> {{ trans('social_works.social_work')  }}: {{ $protocol->plan->social_work->name }} </td>
            <td> </td>
        </tr>
    </table>
@endsection

@section('body')
    @foreach ($practices as $practice)
        @if (!empty($practice->report->report))
            <div class="page-break-inside">
            {!! $practice->print() !!}
            <hr>
            </div>
        @endif
    @endforeach
@endsection
