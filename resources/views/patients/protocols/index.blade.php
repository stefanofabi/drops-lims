@extends('patients/default-template')

@section('title')
{{ trans('protocols.protocols') }}
@endsection

@section('js')
    <script type="module">
        $(document).ready(function() {
            // Put the patient
            $("#patient").val('{{ $patient }}');
        });
    </script>
@endsection

@section('active_protocols', 'active')

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.protocols') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('protocols.patient_protocols_message') }}
</p>
@endsection

@section('content')
<form>
    <div class="row">
        <div class="col-md-6 mt-3">
            <label for="startDate">{{ trans('forms.start_date') }} </label>
            <input type="date" class="form-control" id="startDate" name="initial_date" value="{{ $initial_date ?? date('Y-m-d', strtotime(date('Y-m-d').'- 30 days')) }}" aria-describedby="startDateHelp" required>
            <div id="startDateHelp" class="form-text">
                {{ trans('protocols.search_protocols_from_help') }}
            </div>
        </div>
        
        <div class="col-md-6 mt-3">
            <label for="endDate">{{ trans('forms.end_date') }}</label>
            <input type="date" class="form-control" id="endDate" name="ended_date" value="{{ $ended_date ?? date('Y-m-d') }}" aria-describedby="endDateHelp" required>
            <div id="endDateHelp" class="form-text">
                {{ trans('protocols.search_protocols_until_help') }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mt-3">
            <label for="patient">{{ trans('patients.patient') }}</label>
            
            <select class="form-select" id="patient" name="internal_patient_id" aria-describedby="patientHelp" required>
                <option value="">{{ trans('forms.select_option') }}</option>
                @foreach ($family_members as $family_member)
                <option value="{{ $family_member->internalPatient->id }}"> {{ $family_member->internalPatient->last_name }} {{ $family_member->internalPatient->name }}</option>
                @endforeach
            </select>

            <div id="patientHelp" class="form-text">
                {{ trans('protocols.search_patient_protocols_help') }}
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div for="inputState"> &nbsp </div>
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-search" ></span> {{ trans('forms.search') }} 
            </button>
        </div>
    </div>    
</form>

@if ($protocols->isNotEmpty())
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <tr>
            <th> {{ trans('protocols.protocol_number') }} </th>
            <th> {{ trans('protocols.completion_date') }} </th>
            <th> {{ trans('prescribers.prescriber') }} </th>
            <th class="text-end"> {{ trans('forms.actions') }} </th>
        </tr>

        @foreach ($protocols as $protocol)
            <tr>
                <td> 
                    #{{ $protocol->id }} 

                    @if ($protocol->isClosed())
                    <span class="badge bg-success bg-sm"> {{ trans('protocols.closed') }} </span>
                    @endif
                </td>
                <td> {{ date(Drops::getSystemParameterValueByKey('DATE_FORMAT'), strtotime($protocol->completion_date)) }} </td>
                <td> {{ $protocol->prescriber->full_name }} </td>

                <td class="text-end">
                    <a href="{{ route('patients/protocols/show', $protocol->id) }}" class="btn btn-primary btn-sm verticalButtons" title="{{ trans('protocols.show_protocol') }}" >
                        <i class="fas fa-eye fa-sm"></i> 
                    </a>

                    <a target="_blank" href="{{ route('patients/protocols/generate_protocol', ['id' => $protocol->id]) }}" class="btn btn-primary btn-sm verticalButtons @if (empty($protocol->closed)) disabled @endif" title="{{ trans('protocols.generate_protocol') }}"> 
                        <i class="fas fa-print fa-sm"></i> 
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@elseif (! empty($patient))
<p class="text-danger mt-3"> {{ trans('protocols.search_protocols_is_empty') }} </p> 
@endif
@endsection