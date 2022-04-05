@extends('emails/base')

@section('header')
<div style="background-color: #AABBCC; min-height: 50px; padding-left: 10px; padding-top: 15px">
    <a href="{{ route('login') }}"> <img src="{{ asset('images/small_logo.png') }}"> </a>
</div>
@endsection

@section('body')
<h1> {{ trans('emails.results_ready') }} </h1>

<p> 
    <b> {{ trans('protocols.protocol_number') }}: </b> #{{ $protocol->id }} <br />
    <b> {{ trans('protocols.completion_date') }}: </b> {{ date('d/m/Y', strtotime($protocol->completion_date)) }} <br />
    <b> {{ trans('patients.patient') }}: </b> {{ $protocol->patient->full_name }} <br /> 
    <b> {{ trans('social_works.social_work') }}: </b> {{ $protocol->plan->social_work->name ?? trans('social_works.particular') }} <br /> 
    <b> {{ trans('prescribers.prescriber') }}: </b> {{ $protocol->prescriber->name ?? trans('social_works.particular') }} 
</p>

<p>
    <h2> {{ trans('practices.practices') }} </h2>

    <ul>
        @foreach ($protocol->practices as $practice)
            <li> {{ $practice->report->determination->name }} </li>
        @endforeach
    </ul>
</p>

<p style="color: red; margin-top: 3%">
{{ trans('emails.security_notice') }}
<br /> <br />
{{ trans('emails.confidentiality_notice') }}
</p>
@endsection


@section('footer')
<div style="background-color: #AABBCC; min-height: 30px; padding-left: 10px; padding-top: 10px">
     &#169 {{ date('Y') }} {{ env('APP_NAME', 'Drops LIMS') }}. {{ trans('emails.all_rights_reserved') }}.
</div>
@endsection