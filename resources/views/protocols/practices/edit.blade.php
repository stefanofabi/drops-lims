@extends('default-template')

@section('title')
{{ trans('protocols.edit_practice') }}
@endsection 

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
		
	function edit_practice() {

		var array = [];

		$('#report').find('input, select').each(function() {
			console.log($(this).val());
    		array.push($(this).val());
    		
 		 });

		var parameters = {
			"_token": '{{ csrf_token() }}',
			"data" : array,
		};

		$.ajax({
			data:  parameters,
			url:   '{{ route("protocols/practices/update", $practice->id) }}',
			type:  'put',
			beforeSend: function () {
						$("#messages").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
					},
			success:  function (response) {
						$("#messages").html('<div class="spinner-border text-info"> </div> OK!');
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
		<a class="nav-link" href="{{ route('protocols/our/edit', [$practice->protocol_id]) }}"> <img src="{{ asset('img/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.edit_protocol') }} #{{ $practice->id }}
@endsection


@section('content')

	<div id="messages">
	</div>


	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $determination['name'] }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>
		
		<input type="text" class="form-control" value="{{ $report->name }}" disabled>
	</div>

		<form method="post" action="{{ route('protocols/practices/update', [$practice->id]) }}" onsubmit="return edit_practice()">
			@csrf
			{{ method_field('PUT') }}

			<div class="card mt-3">	
				<div class="card-header">
					<h6> Result </h6>
				</div>

				<div id="report" class="card-body">
					{!! $report->report !!}
				</div>

				<div class="card-header">
					<div class="mt-3 float-right">
						<button type="submit" class="btn btn-primary">
							<span class="fas fa-save"></span> {{ trans('forms.save') }}
						</button>
					</div>
				</div>
			</div>
		</form>
@endsection
