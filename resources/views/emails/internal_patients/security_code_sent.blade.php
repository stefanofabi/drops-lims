@extends('emails/base')

@section('title')
{{ trans('patients.security_code_for', ['id' => $patient->id]) }}
@endsection

@section('header')
<div style="background-color: #AABBCC; min-height: 50px; padding-left: 10px; padding-top: 15px">
    <a href="{{ route('login') }}"> <img src="{{ asset('images/small_logo.png') }}"> </a>
</div>
@endsection

@section('body')
<h1> {{ trans('emails.new_secutiry_code') }} </h1>

<p>
    <b> {{ trans('patients.patient') }}: </b> {{ $patient->full_name }} <br />
    <b> {{ trans('patients.unique_identifier') }}: </b> {{ $patient->id }} <br />
</p>

<p>
    {{ trans('patients.expiration_notice', ['date' => $expiration_date]) }}
</p>

<p style="background-color: #DFDDDC; width: 500px; height: 40px;text-align: center; margin-left: 15%; margin-top: 2%; padding-top: 20px; font-size: 20px">
    <strong> {{ trans('patients.security_code') }}: {{ $security_code }} </strong>
</p>

<p style="color: red;">
    {{ trans('patients.notice_confidentiality') }}
</p>
@endsection

@section('footer')
<div style="background-color: #AABBCC; min-height: 30px; padding-left: 10px; padding-top: 10px">
     &#169 {{ date('Y') }} {{ env('APP_NAME', 'Drops LIMS') }}. {{ trans('emails.all_rights_reserved') }}.
</div>
<p style="font-size:10px"> {{ trans('emails.confidentiality_notice') }} </p>
@endsection