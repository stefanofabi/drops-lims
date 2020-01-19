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
{{ trans('patients.edit_patient') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/phones/create', [$industrial['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/emails/create', [$industrial['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/industrials/show', [$industrial['id']]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.go_back') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
{{ trans('patients.edit_patient') }}
@endsection

@section('content')
<form method="post" action="{{ route('patients/industrials/update', ['id' => $industrial['id']]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> {{ trans('patients.complete_personal_data') }} </h4>
		</div>
		<div class="card-body">
			<div class="input-group mb-6 col-md-6">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>

				<input type="text" class="form-control" name="name" value="{{ $industrial['name'] }}" required>
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
				<input type="text" class="form-control" name="business_name" value="{{ $industrial['business_name'] }}">
			</div>

			<div class="input-group mb-10 col-md-10" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.cuit') }} </span>
				</div>
				<input type="number" class="form-control" name="cuit" value="{{ $industrial['cuit'] }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
				</div>

				<select class="form-control input-sm" name="tax_condition" id="tax_condition">
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
				<input type="text" class="form-control" name="fiscal_address" value="{{ $industrial['fiscal_address'] }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city" value="{{ $industrial['city'] }}">
			</div>

			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
				</div>

				<input type="date" class="form-control" name="start_activity" value="{{ $industrial['start_activity'] }}">
			</div>

		</div>
	</div>


	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-book"></i> {{ trans('patients.complete_contact_information') }} </h4>
		</div>

		<div class="card-body">
			@include('patients/phones/index')

			@include('patients/emails/index')

		</div>
	</div>

	@include('patients/social_works/affiliates/index')

	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('patients.save') }}
		</button>
	</div>	

</form>
@endsection