@extends('pdf/base')

@section('title')
    {{ trans('protocols.protocol_number') }}
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
@endsection

@section('body')
    <div style="margin-left: 5%; margin-top: 2%">
        {{ trans('patients.patient') }}: {{ $patient->full_name }} <br />
        {{ trans('patients.unique_identifier') }}: {{ $patient->id }} <br />
        <br />
        {{ trans('patients.expiration_notice', ['date' => date('d/m/Y', strtotime($expiration_date))]) }} <br />
    </div>


    <div style="margin-left: 5%; margin-top: 1%; color: red;">
        {{ trans('patients.notice_confidentiality') }}
    </div>

    <div style="background-color: #DFDDDC; width: 500px; height: 40px;text-align: center; margin-left: 15%; margin-top: 2%; padding-top: 20px; font-size: 20px">
        <strong> {{ trans('patients.security_code') }}: {{ $security_code }} </strong>
    </div>
@endsection
