@extends('emails/base')

@section('title')
{{ trans('emails.welcome_to_our_laboratory', ['laboratory_name' => Drops::getSystemParameterValueByKey('LABORATORY_NAME')]) }}
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
<h2> {{ trans('emails.hello', ['name' => $user->name]) }} </h2>

<p> {{ trans('emails.welcome_to_your_trusted_laboratory', ['laboratory_name' => Drops::getSystemParameterValueByKey('LABORATORY_NAME')]) }}. </p>
<p> {{ trans('emails.your_account_information') }} </p>

<ul>
    <li> <strong>{{ trans('auth.email_address') }}:</strong> {{ $user->email }} </li>
    <li> <strong>{{ trans('auth.password') }}:</strong> <a href="{{ route('password.request') }}" target="_blank"> {{ trans('emails.generate_new_password') }} </a> </li>
</ul>

<p> {{ trans('emails.password_confidentiality') }}. </p>
<p> {{ trans('emails.access_to_our_services', ['laboratory_name' => Drops::getSystemParameterValueByKey('LABORATORY_NAME')]) }}. </p>

<p> {{ trans('emails.need_assistance', ['secretary_email' => Drops::getSystemParameterValueByKey('SECRETARY_EMAIL')]) }}. </p>

<p> {{ trans('emails.appreciate_your_trust_and_have_positive_experience') }}. </p>
@endsection

@section('footer')
<div class="footerBox">
     &#169 {{ date('Y') }} {{ Drops::getSystemParameterValueByKey('LABORATORY_NAME') }}. {{ trans('emails.all_rights_reserved') }}.
</div>

<p style="font-size:10px"> {{ trans('emails.confidentiality_notice') }} </p>
@endsection