@extends('administrators/default-template')

@section('title')
{{ trans('patients.create_patient') }}
@endsection

@section('active_patients', 'active')

@section('js')
<script type="module">
	$(document).ready(function() 
	{
        // Select a option from list
        $('#sex').val("{{ @old('sex') }}");
    });

    const autoCompleteJS = new autoComplete({
        selector: "#socialWorkAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/social_works/getSocialWorks") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#socialWorkAutoComplete").val() }),
                        headers: { 
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "Content-Type" : "application/json",
                        }
                    });
                    
                    // Data should be an array of `Objects` or `Strings`
                    const data = await source.json();

                return data;
                } catch (error) {
                    return error;
                }
            },
            // Data source 'Object' key to be searched
            keys: ["social_work"],
            cache: false,
        },
        searchEngine: function (q, r) { return r; },
        events: {
            input: {
                focus() {
                    autoCompleteJS.start();
                },
            },
        },
        resultItem: {
            element: (item, data) => {
                // Modify Results Item Style
                item.style = "display: flex; justify-content: space-between;";
                // Modify Results Item Content
                item.innerHTML = `
                <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                ${data.match}
                </span>
                <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
                ${data.value.plan}
                </span>`;
            },
            highlight: true
        },
        threshold: 2,
        resultsList: {
            element: (list, data) => {
                if (data.results.length > 0) {
                    const info = document.createElement("div");
                    info.setAttribute("class", "centerAutoComplete");
                    info.innerHTML = `Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results`;
                    list.prepend(info);
                } else {
                    // Create "No Results" message list element
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    // Add message text content
                    message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                    // Add message list element to the list
                    list.appendChild(message);
                }
            },
            noResults: true,
            maxResults: undefined,
        },
    });

    autoCompleteJS.input.addEventListener("selection", function (event) {
        const feedback = event.detail;
        autoCompleteJS.input.blur();

        const selected = feedback.selection.value;

        $('#plan').val(selected.plan_id);
        $('#planAutoComplete').val(selected.plan);
    
        autoCompleteJS.input.value = selected.social_work;
    });
</script>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.create_patient') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('patients.patients_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/patients/store') }}">
    @csrf

    <div class="mt-4">
        <h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="name"> {{ trans('patients.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>

                <small id="nameHelp" class="form-text text-muted"> {{ trans('patients.name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="last_name"> {{ trans('patients.last_name') }} </label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name') }}" aria-describedby="lastNameHelp" required>

                <small id="lastNameHelp" class="form-text text-muted"> {{ trans('patients.last_name_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="identification_number"> {{ trans('patients.identification_number') }} </label>
                <input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" id="identification_number" value="{{ old('identification_number') }}" aria-describedby="identificationNumberHelp">
                
                <small id="identificationNumberHelp" class="form-text text-muted"> {{ trans('patients.identification_number_help') }} </small>
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

                <small id="sexHelp" class="form-text text-muted"> {{ trans('patients.sex_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="home_address"> {{ trans('patients.home_address') }} </label>
                <input type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" id="home_address" value="{{ old('home_address') }}" aria-describedby="homeAddressHelp">

                <small id="homeAddressHelp" class="form-text text-muted"> {{ trans('patients.home_address_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="city"> {{ trans('patients.city') }} </label>
                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" value="{{ old('city') }}" aria-describedby="cityHelp">

                <small id="cityHelp" class="form-text text-muted"> {{ trans('patients.city_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="birthdate"> {{ trans('patients.birthdate') }} </label>
                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" aria-describedby="birthdateHelp">

                <small id="birthdateHelp" class="form-text text-muted"> {{ trans('patients.birthdate_help') }} </small>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
        <hr class="col-6">
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="phone"> {{ trans('patients.phone') }} </label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" placeholder="(12) 345-6789" aria-describedby="phoneHelp">

                <small id="phoneHelp" class="form-text text-muted"> {{ trans('patients.phone_help') }} </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="alternative_phone"> {{ trans('patients.alternative_phone') }} </label>
                <input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" id="alternative_phone" value="{{ old('alternative_phone') }}" placeholder="(12) 345-6789" aria-describedby="alternativePhoneHelp">

                <small id="alternativePhoneHelp" class="form-text text-muted"> {{ trans('patients.alternative_phone_help') }} </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="email"> {{ trans('patients.email') }} </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="patient@domain.com" aria-describedby="emailHelp">

                <small id="emailHelp" class="form-text text-muted"> {{ trans('patients.email_help') }} </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="alternative_email"> {{ trans('patients.alternative_email') }} </label>
                <input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" id="alternative_email" value="{{ old('alternative_email') }}" placeholder="patient@domain.com" aria-describedby="alternativeEmailHelp">

                <small id="alternativeEmailHelp" class="form-text text-muted"> {{ trans('patients.alternative_email_help') }} </small>
		    </div>
        </div>
    </div>

    <div class="mt-4">
        <h4><i class="fas fa-heart"></i> {{ trans('social_works.social_work') }} </h4>
		<hr class="col-6">
    </div>

    <div class="row">
        <div class="col-lg-6 mt-3">
            <div class="form-group mt-2">
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') }}" aria-describedby="socialWorkHelp">
                <br />
                <small id="socialWorkHelp" class="form-text text-muted"> {{ trans('patients.social_work_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="expiration_date"> {{ trans('plans.plan') }} </label>
                <input type="text" class="form-control" name="plan_name" id="planAutoComplete" value="{{ old('plan_name') }}" aria-describedby="planHelp" disabled>
                <input type="hidden" name="plan_id" id="plan" value="{{ @old('plan_id') }}"> 

                <small id="planHelp" class="form-text text-muted"> {{ trans('patients.plan_help') }} </small>
		    </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="affiliate_number"> {{ trans('social_works.affiliate_number') }} </label>
                <input type="text" class="form-control @error('affiliate_number') is-invalid @enderror" name="affiliate_number" id="affiliate_number" value="{{ old('affiliate_number') }}" placeholder="12 345678 9 01" aria-describedby="affiliateNumberHelp">

                <small id="affiliateNumberHelp" class="form-text text-muted"> {{ trans('patients.affiliate_number_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="security_code"> {{ trans('social_works.security_code') }} </label>
                <input type="number" class="form-control @error('security_code') is-invalid @enderror" name="security_code" min="100" max="999" value="{{ old('security_code') }}" placeholder="123" aria-describedby="securityCodeHelp">

                <small id="securityCodeHelp" class="form-text text-muted"> {{ trans('patients.security_code_help') }} </small>
		    </div>
        </div>
 
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="expiration_date"> {{ trans('social_works.expiration_date') }} </label>
                <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}" aria-describedby="expirationDateHelp">

                <small id="expirationDateHelp" class="form-text text-muted"> {{ trans('patients.expiration_date_help') }} </small>
		    </div>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection