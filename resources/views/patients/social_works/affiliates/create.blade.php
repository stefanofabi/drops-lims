@extends('default-template')

@section('title')
{{ trans('patients.add_social_work') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('js')
<script type="text/javascript">
	function load_plans() {
		var parameters = {
			"_token": "{{ csrf_token() }}",
			"social_work" : $("#social_work").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('patients/social_works/plans/load_ajax') }}",
			type:  'post',
			beforeSend: function () {
				$("#plans").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
			},
			success:  function (response) {
						// Load data
						$("#plans").html(response);
					}
				});

		return false;
	}
</script>
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/phones/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_phone') }} </a>
	</li>		

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/emails/create', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_email') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.add_social_work') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('patients/show', [$id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('patients.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
{{ trans('patients.add_social_work') }}
@endsection


@section('content')
<form method="post" action="{{ route('patients/social_works/affiliates/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="patient_id" value="{{ $id }}">

	<div class="input-group mb-6 col-md-6">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<select class="form-control" id="social_work" name="social_work" onchange="load_plans()" required>
			<option value=""> {{ trans('social_works.select_social_work') }} </option>

			@foreach ($social_works as $social_work)
			<option value="{{ $social_work->id }}"> {{ $social_work->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="input-group mb-6 col-md-6" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.plan') }} </span>
		</div>

		<div id="plans">
			<select class="form-control" name="plan" required>
				<option value=""> {{ trans('social_works.select_plan') }} </option>
			</select>
		</div>
	</div>			

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.affiliate_number') }} </span>
		</div>

		<input type="text" class="form-control" name="affiliate_number">
	</div>

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.security_code') }} </span>
		</div>

		<input type="number" class="form-control" name="security_code">
	</div>
	
	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.expiration_date') }} </span>
		</div>

		<input type="date" class="form-control" name="expiration_date">
	</div>

	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


