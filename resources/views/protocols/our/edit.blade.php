@extends('default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a social work from list
        $("#social_work").val('{{ $social_work->id }}');
    });

	$(function() {
		$("#prescriber").autocomplete({
			minLength: 2,
			source: function(event, ui) {
						var parameters = {
							"filter" : $("#prescriber").val()
						};

						$.ajax({
							data:  parameters,
							url:   '{{ route("protocols/our/load_prescribers") }}',
							type:  'post',
							dataType: 'json',
							beforeSend: function () {
										//$("#resultados").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
									},
							success:  ui
						});
						
						return ui;
					},
			select: function(event, ui) {
						event.preventDefault();
						$('#prescriber').val(ui.item.label);
						$('#prescriber_id').val(ui.item.id);
					}
		});
	});

</script>
@endsection

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/add_practice', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.add_practice') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/show', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

<form method="post" action="{{ route('protocols/our/update', [$protocol->id]) }}">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $patient['full_name'] ?? '' }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<select class="form-control input-sm" id="social_work">
				<option value=""> {{ trans('social_works.select_social_work') }}</option>
					@foreach ($social_works as $social_work)
						<option value="{{ $social_work->id }}"> {{ $social_work->name }} </option>
					@endforeach
		</select>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>
		
		<input type="hidden" id="prescriber" name="prescriber_id" value="{{ $prescriber->id }}">
		<input type="text" class="form-control" id="prescriber" value="{{ $prescriber->full_name }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" value="{{ $protocol->completion_date }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.quantity_orders') }} </span>
		</div>

		<input type="number" class="form-control" value="{{ $protocol->quantity_orders }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->diagnostic }}">
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.observations') }} </span>
		</div>

		<textarea class="form-control" rows="3"> {{ $protocol->observations }} </textarea>
	</div>

	<div class="mt-2 float-right">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	

</form>
@endsection

