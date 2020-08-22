@extends('administrators/patients/patients')

@section('js')
	@include('administrators/patients/filters_javascript_code')
@append

@section('results')

	@if (!sizeof($data))
		<div class="col-md-12"> {{ trans('forms.no_results') }}</div>
	@else 

		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th> {{ trans('patients.patient') }} </th>
					<th> {{ trans('patients.owner') }} </th>
					<th> {{ trans('patients.city') }} </th>
					<th> {{ trans('patients.birth_date') }} </th>
					<th class="text-right"> {{ trans('forms.actions') }} </th>
				</tr>

				@foreach ($data as $patient)
					<tr>
						<td> {{ $patient->full_name }} </td>
						<td> {{ $patient->owner }} </td>
						<td> {{ $patient->city }} </td>
						<td> {{ date('d/m/Y', strtotime($patient->birth_date)) }} </td>

						<td class="text-right">
							<a href="{{ route('administrators/patients/show', $patient->id) }}" class="btn btn-info btn-sm float-left" title="{{ trans('patients.show_patient') }}" > <i class="fas fa-eye fa-sm"> </i> </a> 

							<form id="destroy_patient_{{ $patient->id }}" method="POST" action="{{ route('administrators/patients/destroy', $patient->id) }}">
								@csrf
								@method('DELETE')

								<a class="btn btn-info btn-sm" title="{{ trans('patients.destroy_patient') }}" onclick="destroy_patient('{{ $patient->id }}')"> <i class="fas fa-user-slash fa-sm"> </i> </a>
							</form>
						</td>
					</tr>
				@endforeach

				<tr>
					<td colspan="7">
						<span class="float-right">
								{!! $paginate !!}
						</span>
					</td>
				</tr>

			</table>
		</div>
	@endif
@endsection
