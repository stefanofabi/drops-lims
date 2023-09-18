@extends('emails/base')

@section('title')
{{ trans('patients.security_code_for', ['id' => $patient->id]) }}
@endsection

@section('style')
<style>
    .headerBox {
        background-color: {{ Drops::getSystemParameterValueByKey('EMAIL_BOX_BACKGROUND') }};
        min-height: 50px;
        padding: 2%;
    }

    .headerTitle {
        width: 100%;
        padding-left: 3%;
        font-weight: bold;
        font-size: {{ Drops::getSystemParameterValueByKey('EMAIL_FONT_SIZE_TITLE') }};
    }

    .headerSubtitle {
        padding-left: 3%;
        font-weight: bold;
        font-style: italic;
        font-size: {{ Drops::getSystemParameterValueByKey('EMAIL_FONT_SIZE_SUBTITLE') }};
        width: 100%;
    }

    .securityCodeBox {
        background-color: {{ Drops::getSystemParameterValueByKey('EMAIL_BOX_BACKGROUND') }};
        text-align: center;
        margin-left: 5%;
        margin-right: 5%;
        margin-top: 3%;
        padding: 3%;
        font-size: 20px;
    }

    .confidentialityNotice {
        color: red;
    }

    .footerBox {
        background-color: {{ Drops::getSystemParameterValueByKey('EMAIL_BOX_BACKGROUND') }};
        min-height: 30px;
        padding: 2%;
    }

    body {
        font-family: {{ Drops::getSystemParameterValueByKey('EMAIL_FONT_FAMILY') }};
    }
</style>
@endsection

@section('header')
<div class="headerBox">
    <table> 
        <tr>
            <td rowspan="2"> <a href="{{ route('login') }}"> <img src="{{ asset(Drops::getSystemParameterValueByKey('LOGO_IMAGE')) }}" width="104" height="35" title="Drops Lims" alt="Drops logo that simulates a drop"> </a> </td> 
            <td class="headerTitle"> {{ Drops::getSystemParameterValueByKey('EMAIL_TITLE_1') }} </td> 
        </tr> 

        <tr>
            <td class="headerSubtitle"> {{ Drops::getSystemParameterValueByKey('EMAIL_SUBTITLE_1') }} </td>
        </tr>
    </table>
</div>
@endsection

@section('body')
<h2> {{ trans('emails.new_security_code') }} </h2>

<div>
    <b> {{ trans('patients.patient') }}: </b> {{ $patient->full_name }} <br />
    <b> {{ trans('patients.unique_identifier') }}: </b> {{ $patient->id }} <br />
</div>

<div style="margin-top: 3%;">
    {{ trans('patients.expiration_notice', ['date' => $expiration_date]) }}
</div>

<div class="securityCodeBox">
    <strong> {{ trans('patients.security_code') }}: {{ $security_code }} </strong>
</div>

<p class="confidentialityNotice">
    {{ trans('patients.notice_confidentiality') }}
</p>
@endsection

@section('footer')
<div class="footerBox">
     &#169 {{ date('Y') }} {{ Drops::getSystemParameterValueByKey('LABORATORY_NAME') }}. {{ trans('emails.all_rights_reserved') }}.
</div>

<p style="font-size:10px"> {{ trans('emails.confidentiality_notice') }} </p>
@endsection