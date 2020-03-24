@extends('default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">

	$(function() {
		$("#practice").autocomplete({
			minLength: 2,
			source: function(event, ui) {
						var parameters = {
							"nomenclator_id" : $("#nomenclator_id").val(),
							"filter" : $("#practice").val()
						};

						$.ajax({
							data:  parameters,
							url:   '{{ route("protocols/practices/load") }}',
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
						$('#practice').val(ui.item.label);
						$('#report_id').val(ui.item.id);
					}
		});
	});

	function add_practice() {
		var parameters = {
			"_token": "{{ csrf_token() }}",
			"protocol_id" : '{{ $protocol->id }}',
			"report_id" : $("#report_id").val(),
			"type" : 'our',
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('protocols/practices/store') }}",
			type:  'post',
			beforeSend: function () {
				//
			},
			success:  function (response) {

						$("#practices").load(" #practices");
					}
		});
	}
	
</script>
@endsection

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>	

	<li class="nav-item">
		<a class="nav-link" href="{{ route('protocols/our/edit', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

	<div class="row">
	    <div class="col">
	        <span class="float-left col-md-6">
	        	<input type="hidden" id="report_id" value="0">
	        	<input type="hidden" id="nomenclator_id" value="{{ $nomenclator->id }}">
				<input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('protocols.enter_practice') }}">
	        </span>

	        <span class="float-left">	
	        	<button onclick="add_practice()" class="btn btn-primary float-left">
					<span class="fas fa-plus"></span> {{ trans('protocols.add_practice') }}
				</button>
			</span>
	    </div>
	</div>

@endsection	

@section('more-content')
<div id="practices">
	@php use App\Http\Controllers\OurProtocolController; @endphp

    <div class="table-responsive">
		<table class="table table-striped">
				<tr  class="info">
					<th> {{ trans('determinations.code') }} </th>
					<th> {{ trans('determinations.determination') }} </th>	
					<th> {{ trans('determinations.informed') }} </th>	
					<th class="text-right"> {{ trans('forms.actions') }}</th>	
				</tr>

					@foreach (OurProtocolController::get_practices($protocol->id) as $practice)
						<tr>
							<td> {{ $practice->report->determination->code }} </td>
							<td> {{ $practice->report->determination->name }} </td>
							<td> N/A </td>
							<td class="text-right">
								<a href="" class="btn btn-info btn-sm" title=""> <i class="fas fa-edit fa-sm"></i> </a>	
								<a href="" class="btn btn-info btn-sm" title=""> <i class="fas fa-trash fa-sm"></i> </a>			
							</td>
						</tr>
					@endforeach
				
		</table>
	</div>
</div>
@endsection

