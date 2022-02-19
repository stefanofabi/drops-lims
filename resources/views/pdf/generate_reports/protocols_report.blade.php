@extends('pdf/base')

@section('title')
    {{ trans('pdf.protocols_report_from_to', ['initial_date' => date('d/m/Y', strtotime($initial_date)), 'ended_date' => date('d/m/Y', strtotime($ended_date))]) }}
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
        }

        .cover td {
            width: 150mm;
        }

        .small {
            width: 20mm;
        }

        .medium {
            width: 30mm;
        }

        .large {
            width: 80mm;
        }
    </style>
@endsection

@section('header')
    <div id="first_column">
        <img width="80" height="80" src="{{ asset('images/logo.png') }}">
    </div>

    <div id="second_column">
        <table class="cover">
            <tr>
                <td class="title"> {{ trans('pdf.protocols_report_from_to', ['initial_date' => date('d/m/Y', strtotime($initial_date)), 'ended_date' => date('d/m/Y', strtotime($ended_date))]) }}
                </td>
            </tr>
        </table>

        <br/>

        <table class="cover">
            <tr>
                <td> Date: {{ date('d/m/Y') }}  </td>
            </tr>

            <tr>
                <td> Generated by: {{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>
@endsection


@section('body')
    <table style="margin-top: 3%" border="1" cellspacing="0">
        <caption> {{ trans('pdf.total_records') }}: {{ $protocols->count() }} </caption>
        <tr>
            <td class="small"> <strong> {{ trans('pdf.date') }} </strong></td>
            <td class="small"> <strong> {{ trans('protocols.protocol_number') }} </strong></td>
            <td class="large"><strong> {{ trans('patients.patient') }}</strong></td>
            <td class="medium"><strong> {{ trans('social_works.social_work') }}</strong></td>
            <td class="medium"><strong> {{ trans('protocols.total_amount') }} </strong></td>
        </tr>

        @php $total_collection = 0; @endphp

        @foreach ($protocols as $protocol)
            <tr>
                <td> {{ date('d/m/Y', strtotime($protocol->completion_date))  }} </td>
                <td> {{ $protocol->id  }} </td>
                <td> {{ $protocol->patient->full_name  }} </td>
                <td> {{ $protocol->plan->social_work->acronym}} </td>
                <td>
                    @php $total_amount = 0; @endphp

                    @foreach ($protocol->practices as $practice)
                        @php $total_amount += $practice->amount; @endphp
                    @endforeach

                    @php $total_collection += $total_amount; @endphp

                    ${{ $total_amount }}
                </td>

            </tr>
        @endforeach

        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>  </td>
            <td> ${{ $total_collection }} </td>

        </tr>
    </table>


@endsection



