@extends('administrators/default-template')

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

	<input type="hidden" class="form-control" name="id" value="{{ $id }}">

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('phones.phone') }} </span>
		</div>

		<input type="text" class="form-control" name="phone" required>
	</div>


	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('phones.type') }} </span>
		</div>

		<select class="form-control input-sm" name="type">
			<option value=""> {{ trans('forms.select_option') }} </option>
			<option value="{{ trans('phones.landline') }}"> {{ trans('phones.landline') }} </option>
			<option value="{{ trans('phones.mobile') }}"> {{ trans('phones.mobile') }} </option>
			<option value="{{ trans('phones.whatsapp') }}"> {{ trans('phones.whatsapp') }} </option>
		</select>
	</div>


	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


