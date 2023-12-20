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
			<a class="nav-link @if (empty($protocol->closed)) disabled @endif" target="blank" href="{{ route('patients/protocols/generate_protocol', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_protocol') }} </a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="#" onclick="printSelection()"> {{ trans('protocols.generate_protocol_for_selected_practices') }} </a>
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

<div>
	<h4 class="mt-3"> <span class="fas fa-syringe" ></span> {{ trans('practices.practices')}} </h4>
	
	<div class="table-responsive">
		<table class="table table-striped">
			<tr class="info">
				<th>  </th>
				<th> {{ trans('determinations.determination') }} </th>
				<th> {{ trans('practices.informed') }} </th>
				<th> {{ trans('practices.signed_off') }} </th>
				<th class="text-end"> {{ trans('forms.actions') }}</th>
			</tr>

			<form id="print_selection" action="{{ route('patients/protocols/generate_protocol', ['id' => $protocol->id]) }}" target="blank">
				@csrf

				<input type="hidden" name="id" value="{{ $protocol->id }}">
				
				@foreach ($protocol->internalPractices as $practice)
				<tr>
					<td style="width: 50px"> <input type="checkbox" class="form-check-input" name="filter_practices[]" value="{{ $practice->id }}" @if ($practice->signInternalPractices->isEmpty()) disabled @endif> </td>
					<td> {{ $practice->determination->name }} </td>
					
					<td>
						@if (empty($practice->result))
						<span class="badge bg-primary"> {{ trans('forms.no') }} </span>
						@else
						<span class="badge bg-success"> {{ trans('forms.yes') }} </span>
						@endif
					</td>

					<td>
						@forelse($practice->signInternalPractices as $sign)
						<a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
							<img height="30px" width="30px" src="{{ Gravatar::get($sign->user->email) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
						</a>
						@empty
						{{ trans('practices.not_signed')}}
						@endforelse
					</td>
					
					<td class="text-end">
						<a href="{{ route('patients/protocols/practices/show', ['id' => $practice->id]) }}" class="btn btn-primary btn-sm @if ($practice->signInternalPractices->isEmpty()) disabled @endif" title="{{ trans('practices.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>
					</td>
				</tr>
				@endforeach
			</form>
		</table>
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