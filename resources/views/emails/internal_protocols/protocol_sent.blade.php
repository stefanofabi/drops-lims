@extends('emails/base')

@section('header')
<div style="background-color: #AABBCC; min-height: 50px; padding-left: 10px; padding-top: 15px">
    <a href="{{ route('login') }}"> <img src="{{ asset(Drops::getSystemParameterValueByKey('LOGO_IMAGE')) }}" width="104" height="35" title="Drops Lims" alt="Drops logo that simulates a drop"> </a>
</div>
@endsection

@section('body')
<h1> {{ trans('emails.results_ready') }} </h1>

<p> 
    <b> {{ trans('protocols.protocol_number') }}: </b> #{{ $protocol->id }} <br />
    <b> {{ trans('protocols.completion_date') }}: </b> {{ $protocol->completion_date }} <br />
    <b> {{ trans('patients.patient') }}: </b> {{ $protocol->internalPatient->full_name }} <br /> 
    <b> {{ trans('social_works.social_work') }}: </b> {{ $protocol->plan->social_work->name }} <br /> 
    <b> {{ trans('prescribers.prescriber') }}: </b> {{ $protocol->prescriber->full_name }} 
</p>

<p>
    <h2> {{ trans('practices.practices') }} </h2>

    <ul>
        @foreach ($practices as $practice)
            <li> {{ $practice->determination->name }} </li>
        @endforeach
    </ul>
</p>

@if ($protocol->internalPractices->count() > $practices->count())
<p> {{ trans('emails.partial_protocol_notice') }} </p>
@endif

<p style="color: red; margin-top: 3%">
    {{ trans('emails.security_notice') }}
</p>
@endsection


@section('footer')
<div style="background-color: #AABBCC; min-height: 30px; padding-left: 10px; padding-top: 10px">
     &#169 {{ date('Y') }} {{ Drops::getSystemParameterValueByKey('LABORATORY_NAME') }}. {{ trans('emails.all_rights_reserved') }}.
</div>
<p style="font-size:10px"> {{ trans('emails.confidentiality_notice') }} </p>
@endsection