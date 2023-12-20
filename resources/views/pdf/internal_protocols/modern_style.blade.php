@extends('pdf/base')

@section('title')
    {{ trans('protocols.protocol_number') }} #{{ $protocol->id }}
@endsection

@section('style')
    <style>
        .logo {
            padding: 10px;
        }
        
        .letterhead {
            padding: 1%;
            width: 100%;
            background: {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_LETTERHEAD_BACKGROUND_COLOR') }};
        }

        .letterhead td {
            font-family: {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_LETTERHEAD_FONT_FAMILY') }};
        }

        .protocol_info {
            margin: 1%;
            margin-top: 2%;
            padding: 1%;
            width: 100%;
            background: {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_PROTOCOL_INFORMATION_BACKGROUND_COLOR') }};
        }

        .protocol_info td {
            font-family: {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_INFO_FONT_FAMILY') }};
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

        body {
            font-family: {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_FONT_FAMILY') }};
        }
    </style>
@endsection

@section('letterhead')
<table>
    <tr>
        <td>
            <img class="logo" width="100" height="40" src="{{ asset(Drops::getSystemParameterValueByKey('LOGO_IMAGE')) }}">
        </td>

        <td> 
            <table class="letterhead">
                <tr>
                    <td> {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_TITLE_1') }} </td>
                </tr>
            </table>

            <table class="letterhead" style="margin-top: 3%">
                <tr>
                    <td> {{ Drops::getSystemParameterValueByKey('PDF_PROTOCOL_TEXT_LINE_1') }} </td>
                </tr>

                <tr>
                    <td> {{  Drops::getSystemParameterValueByKey('PDF_PROTOCOL_TEXT_LINE_2') }} </td>
                </tr>

                <tr>
                    <td> {{  Drops::getSystemParameterValueByKey('PDF_PROTOCOL_TEXT_LINE_3') }} </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection

@section('protocol_info')
<table class="protocol_info">
    <tr>
        <td> {{ trans('patients.patient') }}: {{ $protocol->internalPatient->full_name  }} </td>
        <td> {{ trans('protocols.protocol_number') }}: #{{ $protocol->id }} </td>
    </tr>

    <tr>
        <td> {{ trans('patients.home_address') }}: {{ $protocol->internalPatient->address }} </td>
        <td>  {{ trans('protocols.completion_date') }}: {{ \Carbon\Carbon::parse($protocol->completion_date)->format(Drops::getSystemParameterValueByKey('DATE_FORMAT')) }} </td>
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

@section('header')
    @yield('letterhead')

    @yield('protocol_info')
@endsection

@section('content')
@foreach ($practices as $practice)
<div class="page-break-inside" style="margin-bottom: 15px">
    {!! $practice->print() !!}
                
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
