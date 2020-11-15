@extends('administrators/default-template')

@section('js')
<script type="text/javascript">

	$(document).ready(function() {
        // Select a type from list
        $("#type").val("{{ old('type') }}");
    });
    
</script>
@endsection

@section('title')
{{ trans('phones.add_phone') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
@include('administrators/patients/edit_menu')
@endsection

@section('content-title')
<i class="fas fa-phone"></i> {{ trans('phones.add_phone') }}
@endsection


@section('content')
<form method="post" action="{{ route('administrators/patients/phones/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="patient_id" value="{{ $patient_id }}">

	<div class="input-group mt-2 col-md-6 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('phones.phone') }} </span>
		</div>

		<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>

		@error('phone')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 col-md-6 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('phones.type') }} </span>
		</div>

		<select class="form-control input-sm @error('type') is-invalid @enderror" id="type" name="type" required>
			<option value=""> {{ trans('forms.select_option') }} </option>
			<option value="Landline"> {{ trans('phones.landline') }} </option>
			<option value="Mobile"> {{ trans('phones.mobile') }} </option>
			<option value="WhatsApp"> {{ trans('phones.whatsapp') }} </option>
		</select>

		@error('type')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="float-right mt-4">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	