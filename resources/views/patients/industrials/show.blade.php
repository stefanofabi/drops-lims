@extends('default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#tax_condition option[value='{{ $industrial['tax_condition'] ?? '' }}']").attr("selected",true);
    });
</script>
@endsection

@section('title')
{{ trans('patients.show_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<p>
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Crear protocolo </a>
		</li>		

		<li class="nav-item">
			<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> Ver protocolos</a>
		</li>
	</ul>
</p>
@endsection

@section('content-title')
{{ trans('patients.show_patient') }}
@endsection

@section('content')
<div class="alert alert-info fade show">
	<a href="{{ route('patients/industrials/edit', [$industrial['id']]) }}" class="btn btn-info btn-sm"> <i class="fas fa-lock-open"></i> </a>
	{{ trans('patients.patient_blocked') }}
</div>

<div class="card">
	<div class="card-header">
		<h4><i class="fas fa-toolbox"></i> {{ trans('patients.shunt') }} </h4>
	</div>
	<div class="card-body">
		<div class="input-group mb-6 col-md-6">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.shunt') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial['shunt'] }}" disabled>
		</div>
	</div>
</div>

<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4><i class="fas fa-toolbox"></i> {{ trans('patients.personal_data') }} </h4>
	</div>
	<div class="card-body">
		<div class="input-group mb-6 col-md-6">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.name') }} </span>
			</div>

			<input type="text" class="form-control" value="{{ $industrial['name'] }}" disabled>
		</div>
	</div>
</div>

<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4><i class="fas fa-id-card"></i> {{ trans('patients.complete_fiscal_data') }} </h4>
	</div>

	<div class="card-body">
		<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.business_name') }}</span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial['business_name'] }}" disabled>
		</div>

		<div class="input-group mb-10 col-md-10" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
			</div>
			<input type="number" class="form-control" value="{{ $industrial['cuit'] }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
			</div>

			<select class="form-control input-sm" id="tax_condition" disabled>
				<option value=""> {{ trans('patients.select_condition') }}</option>
				@foreach ($tax_conditions as $condition)
				<option value="{{ $condition->name}}"> {{ $condition->name }} </option>
				@endforeach
			</select>
		</div>

		<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.fiscal_address') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial['fiscal_address'] }}" disabled>

			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.city') }} </span>
			</div>
			<input type="text" class="form-control" value="{{ $industrial['city'] }}" disabled>
		</div>

		<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
			</div>

			<input type="date" class="form-control" value="{{ $industrial['start_activity'] }}" disabled>
		</div>

	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4><i class="fas fa-book"></i> {{ trans('patients.contact_information') }} </h4>
	</div>

	<div class="card-body">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.phones') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" style="margin-right: 1%" readonly>
				<option value=""> {{ trans('patients.select_phone') }}</option>
			</select>
		</div>


		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.emails') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" style="margin-right: 1%" readonly>
				<option value=""> {{ trans('patients.select_email') }}</option>
			</select>
		</div>
	</div>
</div>


@endsection