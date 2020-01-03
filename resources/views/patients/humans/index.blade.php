@extends('patients/patients')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('patients.patient') }} </th>
				<th> {{ trans('patients.dni') }} </th>
				<th> {{ trans('patients.city') }} </th>
				<th> {{ trans('patients.home_address') }} </th>  
				<th> {{ trans('patients.birth_date') }} </th>
				<th class="text-right"> {{ trans('patients.actions') }} </th>
			</tr>

			@foreach ($data as $patient)
			<tr>
				<td> {{ $patient->last_name }}, {{ $patient->name }} </td>
				<td> {{ $patient->dni }} </td>
				<td> {{ $patient->city }} </td>
				<td> {{ $patient->home_address }} </td>
				<td> {{ $patient->birth_date }} </td>

				<td class="text-right">
					<a href="{{ route('patients/humans/show', [$patient->id]) }}" class="btn btn-info btn-sm" title="{{ trans('patients.show_patient') }}" > <i class="fas fa-user-edit fa-sm"></i> </a> 
					<a href="{{ route('patients/humans/destroy', [$patient->id]) }}" class="btn btn-info btn-sm" title="{{ trans('patients.destroy_patient') }}"> <i class="fas fa-user-slash fa-sm"></i> </a>
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
</div>
@endsection
