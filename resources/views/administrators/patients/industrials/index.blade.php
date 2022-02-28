@extends('administrators/patients/patients')

@section('js')
@include('administrators/patients/filters_javascript_code')
@append

@section('content')
@parent

<div class="table-responsive mt-3">
	<table class="table table-striped">
		<tr>
			<th> {{ trans('patients.patient') }} </th>
			<th> {{ trans('patients.business_name') }} </th>
			<th> {{ trans('patients.cuit') }} </th>
			<th> {{ trans('patients.city') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($patients as $patient)
		<tr>
			<td> {{ $patient->full_name }} </td>
			<td> {{ $patient->business_name }} </td>
			<td> {{ $patient->identification_number }} </td>
			<td> {{ $patient->city }} </td>


			<td class="text-end">
				<a href="{{ route('administrators/patients/edit', $patient->id) }}" class="btn btn-info btn-sm" title="{{ trans('patients.edit_patient') }}" > <i class="fas fa-user-edit fa-sm"></i> </a> 

				<a class="btn btn-info btn-sm" title="{{ trans('patients.destroy_patient') }}" onclick="destroy_patient('{{ $patient->id }}')"> <i class="fas fa-user-slash fa-sm"> </i> </a>
						
				<form id="destroy_patient_{{ $patient->id }}" method="POST" action="{{ route('administrators/patients/destroy', $patient->id) }}">
					@csrf
					@method('DELETE')
				</form>
			</td>
		</tr>
		@endforeach
	</table>
</div>

{!! $paginate !!}
@endsection
