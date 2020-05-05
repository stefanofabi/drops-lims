@extends('administrators/default-template')

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
							"nomenclator_id" : '{{ $nomenclator->id }}',
							"filter" : $("#practice").val()
						};

						$.ajax({
							data:  parameters,
							url:   '{{ route("administrators/protocols/practices/load") }}',
							type:  'post',
							dataType: 'json',
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
			url:   "{{ route('administrators/protocols/practices/store') }}",
			type:  'post',
			beforeSend: function () {
						$("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			error: function(xhr, status) {
        		$("#messages").html('<div class="alert alert-danger"> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.please_later")}}  </div> ');
    		},
			success:  function (response) {
						$("#messages").html('<div class="alert alert-success alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("protocols.practice_loaded") }} </div>');
						$("#practices").load(" #practices");

						// delete data
						$('#practice').val('');
						$('#report_id').val('');
					}
		});

		return false;
	}
	
</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>	

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/protocols/our/edit', [$protocol->id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

	<div id="messages"> </div>

	<div class="col-md-12">
			<form onsubmit="return add_practice()">
		        <span class="float-left mb-2 col-md-6">
		        	<input type="hidden" id="report_id" value="0">
					<input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('protocols.enter_practice') }}">
		        </span>

		        <span class="col-md-3 float-left">	
			    	<button type="submit" class="btn btn-primary">
						<span class="fas fa-plus"></span> {{ trans('protocols.add_practice') }}
					</button>
				</span>
			</form>
	</div>

@endsection	

@section('more-content')

<div class="card mt-3 mb-4">
	<div class="card-header">
		<h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

    <div id="practices">
	    <div class="table-responsive">
			<table class="table table-striped">
					<tr class="info">
						<th> {{ trans('determinations.code') }} </th>
						<th> {{ trans('determinations.determination') }} </th>	
						<th> {{ trans('determinations.amount') }} </th>
						<th> {{ trans('determinations.informed') }} </th>	
						<th class="text-right"> {{ trans('forms.actions') }}</th>	
					</tr>

					@php 
						use App\Http\Controllers\OurProtocolController;
						$total_amount = 0;
					@endphp

					@foreach (OurProtocolController::get_practices($protocol->id) as $practice)

						@php
							$total_amount += $practice->amount;
						@endphp
						<tr>
							<td> {{ $practice->report->determination->code }} </td>
							<td> {{ $practice->report->determination->name }} </td>
							<td> $ {{ number_format($practice->amount, 2, ",", ".") }} </td>
							<td> 
								@if (empty($practice->results->first()))
									<span class="badge badge-primary"> {{ trans('forms.no') }} </span>
								@else 
									<span class="badge badge-success"> {{ trans('forms.yes') }} </span>
								@endif
							</td>
							<td class="text-right">
								<a href="{{ route('administrators/protocols/practices/edit', $practice->id) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_practice') }}"> <i class="fas fa-edit fa-sm"></i> </a>		
								<a href="{{ route('administrators/protocols/practices/destroy', $practice->id) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_practice') }}"> <i class="fas fa-trash fa-sm"></i> </a>		
							</td>
						</tr>
					@endforeach

					<tr>
						<td colspan="5" class="text-right">
							<h4> Total: $ {{ number_format($total_amount, 2, ",", ".") }} </h4>
						</td>
					</tr>
			</table>
		</div>
	</div>
</div>
@endsection

