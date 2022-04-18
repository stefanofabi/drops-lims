@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a option from list
        $('#sex').val("{{ @old('sex') ?? $patient->sex }}");

		@if (sizeof($errors) > 0)
		enableSubmitForm();
		@endif
    });

	function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');

		$("#submitButton").removeAttr('disabled');
	}

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

@section('title')
{{ trans('patients.edit_patient') }}
@endsection

@section('active_patients', 'active')

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
       @can('crud_protocols')
	        <li class="nav-item">
				<form action="{{ route('administrators/protocols/create') }}" id="create_protocol_form">
		            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
		        </form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('create_protocol_form').submit();"> {{ trans('protocols.create_protocol')}} </a>
			</li>
		@endcan

		@if(auth()->user()->can('generate_security_codes'))
			<li class="nav-item">
				<form id="security_code_form" action="{{ route('administrators/patients/security_codes/store') }}" method="post">
					@csrf

					<input type="hidden" name="patient_id" value="{{ $patient->id }}">
				</form>

				<a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('security_code_form').submit();"> {{ trans('patients.send_security_code') }} </a>
			</li>
		@endif
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="mt-3 alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('patients.patient_blocked') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/patients/update', $patient->id) }}">
    @csrf
    {{ method_field('PUT') }}

    <div class="col-10 mt-3">  
        <h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

		<div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.last_name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $patient->last_name }}" required readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $patient->name }}" required readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.identification_number') }} </span>
            </div>
            
            <input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ old('identification_number') ?? $patient->identification_number }}" readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.home_address') }} </span>
            </div>
            
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $patient->address }}" readonly>

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.city') }} </span>
            </div>
            
            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') ?? $patient->city }}" readonly>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.sex') }} </span>
            </div>

            <select class="form-select @error('sex') is-invalid @enderror" name="sex" id="sex" required disabled>
                <option value=""> {{ trans('forms.select_option') }} </option>
                <option value="F"> {{ trans('patients.female') }} </option>
                <option value="M"> {{ trans('patients.male') }} </option>
            </select>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.birthdate') }} </span>
            </div>

            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') ?? $patient->birthdate }}" readonly>
        </div>   

		<div class="mt-3">
			<h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phone') }} </span>
				</div>
				<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ @old('phone') ?? $patient->phone }}" readonly>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_phone') }} </span>
				</div>
				<input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" value="{{ @old('alternative_phone') ?? $patient->alternative_phone }}" readonly>
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.email') }} </span>
				</div>
				<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ @old('email') ?? $patient->email }}" readonly>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_email') }} </span>
				</div>
				<input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" value="{{ @old('alternative_email') ?? $patient->alternative_email }}" readonly>
			</div>
		</div>

        <div class="mt-3">
            <h4><i class="fas fa-heart"></i> {{ trans('social_works.social_work') }} </h4>
			<hr class="col-6">

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
                </div>

                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="@if (old('social_work_name')) {{ old('social_work_name') }} @elseif ($patient->plan_id) {{ $patient->plan->social_work->name }} - {{ $patient->plan->name }} @endif" required readonly>
                <input type="hidden" name="plan_id" id="plan" value="{{ @old('plan_id') ?? $patient->plan_id }}">
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.affiliate_number') }} </span>
                </div>

                <input type="text" class="form-control @error('affiliate_number') is-invalid @enderror" name="affiliate_number" value="{{ old('affiliate_number') ?? $patient->affiliate_number }}" readonly>
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.security_code') }} </span>
                </div>

                <input type="number" class="form-control @error('security_code') is-invalid @enderror" name="security_code" min="100" max="999" value="{{ old('security_code') ?? $patient->security_code }}" readonly>
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.expiration_date') }} </span>
                </div>

                <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') ?? $patient->expiration_date }}" readonly>
            </div>
        </div>
    </div>
    
    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" id="submitButton" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection