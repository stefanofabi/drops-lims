@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $('#sex').val('{{ $patient->sex }}');
    });

    function create_protocol() {
    	var token = '{{ csrf_token() }}';
    	var patient = '{{ $patient->id }}';

    	redirect_by_post('{{ route("administrators/protocols/our/create") }}', { patient_id: patient, '_token': token }, false)
    }

    /* function to redirect a webpage to another using post method */
	function redirect_by_post(purl, pparameters, in_new_tab) {
	    pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
	    in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;

	    var form = document.createElement("form");
	    $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
	    if (in_new_tab) {
	        $(form).attr("target", "_blank");
	    }
	    $.each(pparameters, function(key) {
	        $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
	    });
	    document.body.appendChild(form);
	    form.submit();
	    document.body.removeChild(form);

	    return false;
	}
</script>
@endsection

@section('title')
{{ trans('patients.show_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href="#" onclick="create_protocol()"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Crear protocolo </a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Ver protocolos</a>
		</li>
	</ul>
</p>
@endsection


@section('content-title')
<i class="fas fa-user-shield"></i> {{ trans('patients.show_patient') }}
@endsection


@section('content')

<div class="alert alert-info fade show">
	<a href="{{ route('administrators/patients/edit', $patient->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('forms.personal_data') }} </h4>
	</div>

	<div class="card-body">

		<div class="input-group mt-2 col-md-9">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.dni') }} </span>
			</div>
			<input type="number" class="form-control" value="{{ $patient->key }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.full_name') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->full_name }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->address }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $patient->city }}" disabled>
		</div>

		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.sex') }} </span>
			</div>

			<select class="form-control input-sm" id="sex" disabled>
				<option value=""> {{ trans('patients.select_sex') }} </option>
				<option value="F"> {{ trans('patients.female') }} </option>
				<option value="M"> {{ trans('patients.male') }} </option>
			</select>
		</div>


		<div class="input-group mt-2 col-md-9 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
			</div>

			<input type="date" class="form-control" value="{{ $patient->birth_date }}" disabled>
		</div>

	</div>
</div>

<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('forms.contact_information') }} </h4>
	</div>

	<div class="card-body">
		@include('administrators/patients/phones/show')

		@include('administrators/patients/emails/show')
	</div>
</div>

@include('administrators/patients/social_works/affiliates/show')

@endsection