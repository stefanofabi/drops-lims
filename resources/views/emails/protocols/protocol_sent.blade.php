@extends('emails/base')

@section('header')
<div style="background-color: #AABBCC; height: 50px; padding-left: 10px; padding-top: 15px">
    <a href="{{ route('login') }}"> <img src="{{ asset('images/small_logo.png') }}"> </a>
</div>
@endsection

@section('body')

<h1> Results ready! </h1>

<p> 
    <b> Number of protocol: </b> #{{ $protocol->id }} <br />
    <b> Date: </b> {{ date('d/m/Y', strtotime($protocol->completion_date)) }} <br />
    <b> Patient: </b> {{ $protocol->patient->full_name }} <br /> 
    <b> Social Work: </b> {{ $protocol->plan->social_work->name ?? trans('social_works.particular') }} <br /> 
    <b> Prescriber: </b> {{ $protocol->prescriber->name ?? trans('social_works.particular') }} 
</p>

<p>
    <h2> Practices </h2>

    <ul>
        @foreach ($protocol->practices as $practice)
            <li> {{ $practice->report->determination->name }} </li>
        @endforeach
    </ul>
</p>

<p style="color: red; margin-top: 3%">
    Security notice: If you received this email in error or wish to unsubscribe from our notices, please contact our laboratory staff as soon as possible. <br /> <br />

    This e-mail message may contain confidential or legally privileged information and is intended only for the use of the intended recipient(s). 
    Any unauthorized disclosure, dissemination, distribution, copying or the taking of any action in reliance on the information herein is prohibited. 
    E-mails are not secure and cannot be guaranteed to be error free as they can be intercepted, amended, or contain viruses. 
    Anyone who communicates with us by e-mail is deemed to have accepted these risks. 
    Our Laboratory is not responsible for errors or omissions in this message and denies any responsibility for any damage arising from the use of e-mail. 
    
</p>
@endsection


@section('footer')
<div style="background-color: #AABBCC; height: 30px; padding-left: 10px; padding-top: 10px">
     &#169 {{ date('Y') }} {{ env('APP_NAME', 'Drops LIMS') }}. All rights reserved.
</div>
@endsection