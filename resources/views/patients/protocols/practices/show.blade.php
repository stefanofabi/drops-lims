@extends('patients/default-template')

@section('title')
{{ trans('practices.result') }}
@endsection

@section('active_protocols', 'active')

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

@section('content')
<div id="messages" class="mt-3"> </div>

<div id="report" class="mt-3">
	{!! $practice->print() !!}
</div>
@endsection
