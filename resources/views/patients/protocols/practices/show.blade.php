@extends('patients/default-template')

@section('title')
{{ trans('practices.result') }}
@endsection

@section('active_protocols', 'active')

@section('css')
<style>
    .pdf-container {
		font-family: monospace, system-ui;
      	background-color: #fff;
      	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      	padding: 20px;
      	border-radius: 5px;
    }
</style>
@endsection

@section('js')
<script type="text/javascript">

	$(document).ready(function() {

		var parameters = {
			"id" : '{{ $practice->id }}'
		};

		$.ajax({
			data:  parameters,
			url:   '{{ route("patients/protocols/practices/get_results") }}',
			type:  'post',
			dataType: "json",
			beforeSend: function () {
						$("#messages").html('<div class="spinner-border text-info mt-3"> </div> {{ trans("forms.please_wait") }}');
					},
			success:  function (response) {
                        $("#messages").html('');
						var i = 0;

						$('#report').find('input, select').each(function() {
							$(this).val(response[i]['result']);
							i++;
 						 });
					}
		}).fail( function() {
            $("#messages").html('<div class="alert alert-danger fade show" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("errors.error_processing_transaction") }} </div>');
        });
    });
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/protocols/show', ['id' => $practice->internalProtocol->id]) }}"> {{ trans('forms.go_back') }} </a>
		</li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('practices.result') }}
@endsection

@section('content-message')
{{  trans('practices.practice_now_available') }}
@endsection

@section('content')
<div id="messages" class="mt-3"> </div>

<div id="report" class="pdf-container mt-3">
	{!! $practice->print() !!}
</div>

<div class="mt-3">
	<p> {{ trans('practices.result_was_verified') }}: </p>

	<ul class="list-group list-group-flush">
		@foreach ($practice->signInternalPractices as $sign)
		<li class="list-group-item"> <img height="30px" width="30px" src="{{ Gravatar::get(Auth::user()->email) }}" class="rounded-circle" alt="Avatar {{ $sign->user->name }}"> <span class="ms-1"> {{ $sign->user->name }} </span> </li>
		@endforeach
	</ul>
</div>
@endsection
