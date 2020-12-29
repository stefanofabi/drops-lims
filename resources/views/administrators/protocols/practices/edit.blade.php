@extends('administrators/default-template')

@section('title')
{{ trans('protocols.edit_practice') }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">

	$(document).ready(function() {
		load_results();
    });

    function load_results() { 
    	var parameters = {
			"practice_id" : '{{ $practice->id }}' 
		}; 

		$.ajax({
			data:  parameters,
			url:   '{{ route("administrators/protocols/practices/results") }}',
			type:  'post',
			beforeSend: function () {
						$("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
					},
			success:  function (response) {
						$("#messages").html('<div class="alert alert-warning alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.warning") }}!</strong> {{ trans("protocols.modified_practice")}} </div>');
						var i = 0;

						$('#report').find('input, select').each(function() {
							$(this).val(response[i]['result'])
							i++;
 						 });
					}
		}).fail( function() {
    		$("#messages").html('<div class="alert alert-danger fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.failed_transaction") }} </div>');
		});	
    }

	function confirm_result(type)  {
		if (confirm('{{ trans("forms.confirm") }}')) {
			switch (type) {
				case 'update': {
					update_practice();
					break;
				}

				@can('sign_practices')
				case 'sign': {
					sign_practice();
					break;
				}
				@endcan
			}
    	}

    	return false;
	}

	function update_practice() {

		var array = [];

		$('#report').find('input, select').each(function() {
			//console.log($(this).val());
    		array.push($(this).val());
    		
 		 });

		var parameters = {
			"_token": '{{ csrf_token() }}',
			"data" : array,
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/protocols/practices/update', [$practice->id]) }}",
			type:  'put',
			dataType: 'json',
			beforeSend: function () {
						$("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
					},
			success:  function () {
						$("#messages").html('<div class="alert alert-success alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("protocols.result_loaded") }} </div> ');
					}
		}).fail( function() {
    		$("#messages").html('<div class="alert alert-danger fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.failed_transaction") }} </div>');
		});			

		return false;
	}

	@can('sign_practices')
	function sign_practice() {

    	var parameters = {
    		"_token": '{{ csrf_token() }}',
		}; 

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/protocols/practices/sign', [$practice->id]) }}",
			type:  'put',
			dataType: 'json',
			beforeSend: function () {
				$("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
					},
			success:  function (response) {
				$("#messages").html('<div class="alert alert-success alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.well_done") }}! </strong> '+ response.message +' </div> ');
					}
		}).fail( function(response) {
			var data = response.responseJSON;
    		$("#messages").html('<div class="alert alert-danger fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.danger") }}! </strong> '+ data.message +' </div>');
		});			

		return false;
	}
	@endif

</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/protocols/our/edit', [$practice->protocol_id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $practice->id }}
@endsection


@section('content')

	<div id="messages">	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $determination->name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>
		
		<input type="text" class="form-control" value="{{ $report->name }}" disabled>
	</div>

		<form method="post" action="#" onsubmit="return false">
			@csrf
			{{ method_field('PUT') }}

			<div class="card mt-3">	
				<div class="card-header">
					<i class="fas fa-poll-h"></i> {{ trans('protocols.result') }}
				</div>

				<div id="report" class="card-body">
					{!! $report->report !!}
				</div>

				<div class="card-header">			
					<div class="mt-3 float-right">					
						<button type="submit" class="btn btn-primary" onclick="return confirm_result('update')">
							<span class="fas fa-save"> </span> {{ trans('forms.save') }} 
						</button>

						@can('sign_practices')
							<button type="submit" class="btn btn-primary" onclick="return confirm_result('sign')">
								<span class="fas fa-signature"> </span> {{ trans('forms.sign') }} 							
							</button>
						@endcan 			
					</div>
				</div>
			</div>
		</form>
@endsection
