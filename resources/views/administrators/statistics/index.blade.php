@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {

	    $("input[type=submit]").click(function() {
	      	var action = $(this).attr('dir');
			$('form').attr('action', action);
	        $('form').submit();
	    });

	});
</script>

@endsection

@section('title')
{{ trans('statistics.statistics') }}
@endsection

@section('active_statistics', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/home') }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection


@section('content-title')
<i class="fas fa-chart-bar"></i> {{ trans('statistics.statistics') }}
@endsection


@section('content')

	<form method="post" action="">
		@csrf

		<div class="input-group mt-2 mb-3 col-md-6 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
			</div>

			<select class="form-control input-sm" name="social_work" id="social_work">
					<option value=""> {{ trans('forms.select_option') }}</option>
						@foreach ($social_works as $social_work)
							<option value="{{ $social_work->id }}">

								{{ $social_work->name }}

							</option>
						@endforeach

			</select>
		</div>

		<div class="input-group mt-2 col-md-6 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('statistics.initial_date') }} </span>
			</div>

			<input type="date" class="form-control" name="initial_date" value="{{ $initial_date ?? date('Y-m-d') }}">
		</div>

		<div class="input-group mt-2 col-md-6 input-form">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('statistics.ended_date') }} </span>
			</div>

			<input type="date" class="form-control" name="ended_date" value="{{ $ended_date ?? date('Y-m-d') }}">
		</div>

		<input type="submit" class="btn btn-success mt-3" value="{{ trans('statistics.annual_collection_social_work') }}" dir="{{ route('administrators/statistics/annual_collection_social_work') }}" />

		<input type="submit" class="btn btn-success mt-3" value="{{ trans('statistics.patient_flow') }}" dir="{{ route('administrators/statistics/patient_flow_per_month') }}" />

		<input type="submit" class="btn btn-success mt-3" value="{{ trans('statistics.track_income') }}" dir="{{ route('administrators/statistics/track_income') }}" />

		</button>
	</form>

	@section('graphs')
	@show

@endsection
