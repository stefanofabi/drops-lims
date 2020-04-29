@extends('patients/patients')

@section('results')

@if (!sizeof($data))
	<div class="col-md-12"> {{ trans('forms.no_results') }}</div>
@else 

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('patients.patient') }} </th>
				<th> {{ trans('patients.dni') }} </th>
				<th> {{ trans('patients.city') }} </th>
				<th> {{ trans('patients.birth_date') }} </th>
				<th class="text-right"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($data as $patient)
			<tr>
				<td> {{ $patient->full_name }} </td>
				<td> {{ $patient->key }} </td>
				<td> {{ $patient->city }} </td>
				<td> {{ date('d/m/Y', strtotime($patient->birth_date)) }} </td>

				<td class="text-right">
					<a href="{{ route('patients/show', [$patient->id]) }}" class="btn btn-info btn-sm" title="{{ trans('patients.show_patient') }}" > <i class="fas fa-eye fa-sm"></i> </a> 
					<a href="{{ route('patients/destroy', [$patient->id]) }}" class="btn btn-info btn-sm" title="{{ trans('patients.destroy_patient') }}"> <i class="fas fa-user-slash fa-sm"></i> </a>
				</td>
			</tr>
			@endforeach


			<tr>
				<td colspan=7>
					<span class="float-right">
							{!! $paginate !!}
					</span>
				</td>
			</tr>

		</table>
	</div>
@endif
@endsection
