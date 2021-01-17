@extends('administrators/default-template')

@section('title')
{{ trans('social_works.add_social_work') }}
@endsection

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('js')
<script type="text/javascript">

	function load_plans() {

		var parameters = {
			"_token": "{{ csrf_token() }}",
			"social_work_id" : $("#social_work").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/settings/social_works/plans/load') }}",
			type:  'post',
			beforeSend: function () {
				$("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }} ');
			},
			success:  function (response) {

						$("#plan").empty();
						var select_plan = new Option('{{ trans('forms.select_option') }}', '');
						$("#plan").append(select_plan);

						$(jQuery.parseJSON(JSON.stringify(response))).each(function() {
						         var option = new Option(this.name, this.id);

								/// jquerify the DOM object 'o' so we can use the html method
								$(option).html(this.name);
								$("#plan").append(option);
						});

						$("#messages").html('');
					}
		});

		return false;
	}

</script>
@endsection

@section('menu')
@include('administrators/patients/edit_menu')

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/edit', $patient->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-address-card"></i> {{ trans('social_works.add_social_work') }}
@endsection


@section('content')

<div id="messages"> </div>

<form method="post" action="{{ route('administrators/patients/social_works/affiliates/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="patient_id" value="{{ $patient->id }}">

	<div class="input-group mt-2 col-md-9">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<select class="form-control" id="social_work" onchange="load_plans()" required>
			<option value=""> {{ trans('forms.select_option') }} </option>

			@foreach ($social_works as $social_work)
			<option value="{{ $social_work->id }}"> {{ $social_work->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="input-group mt-2 col-md-9">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.plan') }} </span>
		</div>

		<select class="form-control @error('plan_id') is-invalid @enderror" id="plan" name="plan_id" required>
			<option value=""> {{ trans('forms.select_option') }} </option>

			@if (isset($plans))
				@foreach ($plans as $plan)
				<option value="{{ $plan->id }}"> {{ $plan->name }}</option>
				@endforeach
			@endif
		</select>

		@error('plan_id')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.affiliate_number') }} </span>
		</div>

		<input type="text" class="form-control @error('affiliate_number') is-invalid @enderror" name="affiliate_number" value="{{ old('affiliate_number') }}">

		@error('affiliate_number')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.security_code') }} </span>
		</div>

		<input type="number" class="form-control @error('security_code') is-invalid @enderror" name="security_code" min="100" max="999" value="{{ old('security_code') }}">

		@error('security_code')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.expiration_date') }} </span>
		</div>

		<input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}">

		@error('expiration_date')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="float-right mt-3">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>
</form>
@endsection


