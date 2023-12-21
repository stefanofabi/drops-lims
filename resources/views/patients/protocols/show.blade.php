@extends('patients/default-template')

@section('title')
{{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function printSelection() {
        $('#print_selection').submit();
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/protocols/practices/index', ['internal_protocol_id' => $protocol->id]) }}"> {{ trans('protocols.see_protocol_practices') }} </a>
		</li>

		<li class="nav-item">
			<a class="nav-link @if ($protocol->isOpen()) disabled @endif" target="blank" href="{{ route('patients/protocols/generate_protocol', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_protocol') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('protocols.show_patient_protocol_message') }}
</p>
@endsection

@section('content')
<div class="mt-4">
    <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
    <hr class="col-6">
</div>


<div class="row">
	<div class="col-md-6 mt-1">
        <label for="patient"> {{ trans('patients.patient') }} </label>
        <input type="text" class="form-control" id="patient" value="{{ $protocol->internalPatient->full_name }}" aria-describedby="patientHelp" readonly>

        <small id="patientHelp" class="form-text text-muted"> {{ trans('protocols.patient_help') }} </small>
    </div>

	<div class="col-md-6 mt-1">
		<label for="prescriber"> {{ trans('prescribers.prescriber') }} </label>
        <input type="text" class="form-control" id="prescriber" placeholder="{{ trans('forms.start_typing') }}" value="{{ $protocol->prescriber->full_name }}" aria-describedby="prescriberHelp" readonly>
                
        <div>
            <small id="prescriberHelp" class="form-text text-muted"> {{ trans('protocols.prescriber_help') }} </small>
        </div>
    </div>

</div>

<div class="col-md-6 mt-3">
	<label for="socialWork"> {{ trans('social_works.social_work') }} </label>
    <input type="text" class="form-control" id="socialWork" value="{{ $protocol->plan->social_work->name }}" aria-describedby="socialWorkHelp" readonly>

    <small id="socialWorkHelp" class="form-text text-muted"> {{ trans('protocols.social_work_help') }} </small>
</div>

<div class="row">
	<div class="col-md-6 mt-3">
        <label for="completionDate"> {{ trans('protocols.completion_date') }} </label>
        <input type="date" class="form-control" id="completionDate" value="{{ $protocol->completion_date }}" aria-describedby="completionDateHelp" readonly>
                
        <small id="completionDateHelp" class="form-text text-muted"> {{ trans('protocols.completion_date_help') }} </small>
    </div>

	<div class="col-md-6 mt-3">
        <label for="diagnostic"> {{ trans('protocols.diagnostic') }} </label>
        <input type="text" class="form-control" id="diagnostic" value="{{ $protocol->diagnostic }}" aria-describedby="diagnosticHelp" readonly>
                
        <small id="diagnosticHelp" class="form-text text-muted"> {{ trans('protocols.diagnostic_help') }} </small>
    </div>

</div>

<div class="mt-5">
    <div class="form-group">
    	<h4> <i class="fa-solid fa-magnifying-glass"></i> <label for="observations"> {{ trans('protocols.observations') }} </label> </h4>
        <hr class="col-6">

        <textarea class="form-control" rows="3" id="observations" aria-describedby="observationsHelp" readonly>{{ $protocol->observations }}</textarea>

        <small id="observationsHelp" class="form-text text-muted"> {{ trans('protocols.observations_help') }} </small>
    </div>
</div>
@endsection