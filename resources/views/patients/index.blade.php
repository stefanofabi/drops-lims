@extends('patients/default-template')

@section('title')
{{ trans('home.results') }}
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Put the patient
            $("#patient" ).val('{{ $patient }}');
        });
    </script>
@endsection

@section('active_results', 'active')

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
	    <li class="nav-item">
			<a class="nav-link" href="{{ route('patients/family_members/create') }}"> <span class="fas fa-user-plus" ></span> {{ trans('patients.add_family_member') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('home.results') }}
@endsection

@section('content')
<form>
    <div class="col form-group col-md-6 mt-3">
        <span for="inputState">{{ trans('forms.initial_date') }}</span>
        <input type="date" class="form-control" id="initial_date" name="initial_date" value="{{ $initial_date ?? date('Y-m-d', strtotime(date('Y-m-d').'- 30 days')) }}" required>
    </div>

    <div class="col form-group col-md-6 mt-1">
        <span for="inputState">{{ trans('forms.ended_date') }}</span>
        <input type="date" class="form-control" id="ended_date" name="ended_date" value="{{ $ended_date ?? date('Y-m-d') }}" required>
    </div>

    <div class="col form-group col-md-6 mt-1">
        <span for="inputState">{{ trans('patients.patient') }}</span>
        
        <select class="form-select" id="patient" name="patient_id" required>
            <option value="">{{ trans('forms.select_option') }}</option>
            @foreach ($family_members as $family_member)
            <option value="{{ $family_member->patient->id }}"> {{ $family_member->patient->full_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Filter by keys -->
    <div class="form-group mt-3">
        <div class="col-md-6">
            <button type="submit" class="btn btn-info">
                <span class="fas fa-search" ></span> {{ trans('forms.search') }} 
            </button>
        </div>
    </div>
</form>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <tr>
            <th> {{ trans('protocols.protocol_number') }} </th>
            <th> {{ trans('protocols.completion_date') }} </th>
            <th> {{ trans('prescribers.prescriber') }} </th>
            <th class="text-end"> {{ trans('forms.actions') }} </th>
        </tr>

        @forelse ($protocols as $protocol)
            <tr>
                <td> {{ $protocol->id }} </td>
                <td> {{ date('d-m-Y', strtotime($protocol->completion_date)) }} </td>
                <td> {{ $protocol->prescriber->full_name }} </td>

                <td class="text-end">
                    <a href="{{ route('patients/protocols/show', $protocol->id) }}" class="btn btn-info btn-sm verticalButtons" title="{{ trans('protocols.show_protocol') }}" >
                        <i class="fas fa-eye fa-sm"></i> 
                    </a>

                    <a target="_blank" href="{{ route('patients/protocols/print', $protocol->id) }}" class="btn btn-info btn-sm verticalButtons" title="{{ trans('protocols.print_report') }}"> 
                        <i class="fas fa-print fa-sm"></i> 
                    </a>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan="7">
			    {{ trans('forms.no_results') }}
            </td>
        </tr>
        @endforelse
    </table>
</div>
@endsection