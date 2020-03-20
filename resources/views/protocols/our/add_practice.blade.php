@extends('default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
        // Select a sex from list
        $("#social_work option[value='{{ $protocol->social_work_id }}']").attr("selected",true);
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


	$(function() {
		$("#determination").autocomplete({
			minLength: 2,
			source: function(event, ui) {
						var parameters = {
							"social_work_id" : $("#social_work_id").val(),
							"filter" : $("#determination").val(),
						};

						$.ajax({
							data:  parameters,
							url:   '',
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
						$('#determination').val(ui.item.label);
						$('#report_id').val(ui.item.id);
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
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('protocols.add_practice') }} </a>
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

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol['full_name'] ?? '' }}" disabled>
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
		
		<input type="text" class="form-control" id="prescriber" value="{{ $protocol->prescriber }}">
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

@endsection	

@section('extra-content')
<div class="card margins-boxs-tb">
	<div class="card-header">
		<h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

	<div class="mt-3 mb-3 ml-2">	
		<div class="col-md-6 float-left">	
			<input type="text" class="form-control input-sm" id="determination" placeholder="{{ trans('protocols.enter_determination') }}">
			<input type="hidden" class="form-control input-sm" id="report_id" value="0">
		</div>
		
		<div class="float-left">		
			<button onclick="" class="btn btn-info">
				<span class="fas fa-plus"></span> {{ trans('protocols.add_determination') }}
			</button>
		</div>
	</div>

    <div class="table-responsive">
		<table class="table table-striped">
				<tr  class="info">
					<th> {{ trans('determinations.code') }} </th>
					<th> {{ trans('determinations.determination') }} </th>	
					<th> {{ trans('determinations.informed') }} </th>	
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

				@foreach ($practices as $practice)
					<tr>
						<td> {{ $practice->code }} </td>
						<td> {{ $practice->name }} </td>
						<td> N/A </td>
						<td class="text-right">
							<a href="{{ route('protocols/practices/edit', [$practice->id]) }}" class="btn btn-info btn-sm" title=""> <i class="fas fa-edit fa-sm"></i> </a>			
							<a href="#" class="btn btn-info btn-sm" title="" onclick=""> <i class="fas fa-trash fa-sm"></i> </a>
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
@endsection

