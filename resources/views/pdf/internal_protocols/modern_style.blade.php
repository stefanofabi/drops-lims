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
        <img style="margin-top: 20px" width="100" height="40" src="{{ asset('images/logo.png') }}">
    </div>

    <div id="second_column">
        <table class="cover">
            <tr>
                <td> Title 1</td>
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
            <td> {{ trans('patients.patient') }}: {{ $protocol->internalPatient->full_name  }} </td>
            <td> {{ trans('protocols.protocol_number') }}: #{{ $protocol->id }} </td>
        </tr>

        <tr>
            <td> {{ trans('patients.home_address') }}: {{ $protocol->internalPatient->address }} </td>
            <td>  {{ trans('protocols.completion_date') }}: {{ $protocol->completion_date }} </td>
        </tr>

        <tr>
            <td> {{ trans('prescribers.prescriber') }}: {{ $protocol->prescriber->full_name }} </td>
            <td>
                @php
                    $age = $protocol->internalPatient->age();
                    $format_type = $age != null && $age['year'] > 0;
                @endphp

                {{ trans('patients.age') }}: @if ($age != null) {{ trans_choice('patients.calculate_age', true ? 1 : 0 , $protocol->internalPatient->age()) }} @endif
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
<div class="page-break-inside" style="margin-bottom: 15px">
    {!! $practice->result_template !!}
                
    <table style="width: 100%; margin-top: 3%">
        <tr>
            @foreach  ($practice->signInternalPractices as $sign)
            <td style="text-align: center; line-height: 35%"> 
                <p> @if (! empty($sign->user->signature)) <img src="{{ asset('storage/signatures/'.$sign->user->signature) }}" witdh="120" height="80"> @endif </p>
                <p> {{ $sign->user->full_name }} </p>
                <p> 
                    @if (! empty($sign->user->primary_enrollment)) <span> {{ $sign->user->primary_enrollment }} </span> @endif  
                    @if (! empty($sign->user->primary_enrollment)) <span> {{ $sign->user->secondary_enrollment }} </span> @endif
                </p>
            </td>
            @endforeach
        </tr>
    </table>
</div>
@endforeach
@endsection
