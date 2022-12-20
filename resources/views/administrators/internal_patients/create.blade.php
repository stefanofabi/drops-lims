@extends('administrators/default-template')

@section('title')
{{ trans('patients.create_patient') }}
@endsection

@section('active_patients', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() 
	{
        // Select a option from list
        $('#sex').val("{{ @old('sex') }}");
    });

    $(function () 
    {
        $("#socialWorkAutoComplete").autocomplete({
            minLength: 2,
            source: function (event, ui) {
                var parameters = {
                    "filter": $("#socialWorkAutoComplete").val()
                };

                $.ajax({
                    data: parameters,
                    url: '{{ route("administrators/settings/social_works/getSocialWorks") }}',
                    type: 'post',
                    dataType: 'json',
                    success: ui
                });

                return ui;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#plan').val(ui.item.plan_id);
                $('#socialWorkAutoComplete').val(ui.item.label);
                
            }
        });
    });
</script>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.create_patient') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Every time a new patient arrives, you have to register them in the system in order to later generate a protocol in their name.
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/patients/store') }}">
    @csrf

    <div class="mt-3">
        <h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="name"> {{ trans('patients.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>

                <small id="nameHelp" class="form-text text-muted"> This name is the one that appears when you generate a pdf protocol </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="last_name"> {{ trans('patients.last_name') }} </label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') }}" aria-describedby="lastNameHelp" required>

                <small id="lastNameHelp" class="form-text text-muted"> This last name is the one that appears when you generate a pdf protocol </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="identification_number"> {{ trans('patients.identification_number') }} </label>
                <input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" id="identification_number" value="{{ old('identification_number') }}" aria-describedby="identificationNumberHelp">
                
                <small id="identificationNumberHelp" class="form-text text-muted"> It is the number that identifies a person in a country </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="sex"> {{ trans('patients.sex') }} </label>
                <select class="form-select @error('sex') is-invalid @enderror" name="sex" id="sex" aria-describedby="sexHelp" required>
                    <option value=""> {{ trans('forms.select_option') }} </option>
                    <option value="F"> {{ trans('patients.female') }} </option>
                    <option value="M"> {{ trans('patients.male') }} </option>
                </select>

                <small id="sexHelp" class="form-text text-muted"> Some determinations may only be for one sex </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="home_address"> {{ trans('patients.home_address') }} </label>
                <input type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" id="home_address" value="{{ old('home_address') }}" aria-describedby="homeAddressHelp">

                <small id="homeAddressHelp" class="form-text text-muted"> Street and number where the patient lives </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="city"> {{ trans('patients.city') }} </label>
                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" value="{{ old('city') }}" aria-describedby="cityHelp">

                <small id="cityHelp" class="form-text text-muted"> City where the patient resides </small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="birthdate"> {{ trans('patients.birthdate') }} </label>
                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" aria-describedby="birthdateHelp">

                <small id="birthdateHelp" class="form-text text-muted"> In addition to knowing your age we will send you a greeting on your birthday </small>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
        <hr class="col-6">
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="phone"> {{ trans('patients.phone') }} </label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" placeholder="(12) 345-6789" aria-describedby="phoneHelp">

                <small id="phoneHelp" class="form-text text-muted"> Main cell phone number where we can contact the patient </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="alternative_phone"> {{ trans('patients.alternative_phone') }} </label>
                <input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" id="alternative_phone" value="{{ old('alternative_phone') }}" placeholder="(12) 345-6789" aria-describedby="alternativePhoneHelp">

                <small id="alternativePhoneHelp" class="form-text text-muted"> Secondary cell phone number where we can contact the patient </small>
		    </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="email"> {{ trans('patients.email') }} </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="patient@domain.com" aria-describedby="emailHelp">

                <small id="emailHelp" class="form-text text-muted"> We will send all notifications to this email, including pdf protocols </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="alternative_email"> {{ trans('patients.alternative_email') }} </label>
                <input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" id="alternative_email" value="{{ old('alternative_email') }}" placeholder="patient@domain.com" aria-describedby="alternativeEmailHelp">

                <small id="alternativeEmailHelp" class="form-text text-muted"> Always leave a secondary email in case of any inconvenience </small>
		    </div>
        </div>
    </div>

    <div class="mt-3">
        <h4><i class="fas fa-heart"></i> {{ trans('social_works.social_work') }} </h4>
		<hr class="col-6">
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="socialWorkAutoComplete"> {{ trans('social_works.social_work') }} </label>
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') }}" aria-describedby="socialWorkHelp">
                <input type="hidden" name="plan_id" id="plan" value="{{ @old('plan_id') }}">

                <small id="socialWorkHelp" class="form-text text-muted"> The social or prepaid work that will cover the patient's practices </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="affiliate_number"> {{ trans('social_works.affiliate_number') }} </label>
                <input type="text" class="form-control @error('affiliate_number') is-invalid @enderror" name="affiliate_number" id="affiliate_number" value="{{ old('affiliate_number') }}" placeholder="12 345678 9 01" aria-describedby="affiliateNumberHelp">

                <small id="affiliateNumberHelp" class="form-text text-muted"> Affiliate number as it appears on the affiliate card </small>
		    </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="security_code"> {{ trans('social_works.security_code') }} </label>
                <input type="number" class="form-control @error('security_code') is-invalid @enderror" name="security_code" min="100" max="999" value="{{ old('security_code') }}" placeholder="123" aria-describedby="securityCodeHelp">

                <small id="securityCodeHelp" class="form-text text-muted"> The security code that appears on the back of the affiliate card </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="expiration_date"> {{ trans('social_works.expiration_date') }} </label>
                <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}" aria-describedby="expirationDateHelp">

                <small id="expirationDateHelp" class="form-text text-muted"> We will notify the patient when their card is about to expire </small>
		    </div>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection