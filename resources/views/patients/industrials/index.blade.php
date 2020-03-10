@extends('patients/patients')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('patients.patient') }} </th>
				<th> {{ trans('patients.business_name') }} </th>
				<th> {{ trans('patients.cuit') }} </th>
				<th> {{ trans('patients.city') }} </th>
				<th class="text-right"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($data as $patient)
			<tr>
				<td> {{ $patient->full_name }} </td>
				<td> {{ $patient->business_name }} </td>
				<td> {{ $patient->key }} </td>
				<td> {{ $patient->city }} </td>


				<td class="text-right">
					<a href="{{ route('patients/show', [$patient->id]) }}" class="btn btn-info btn-sm" title="{{ trans('patients.show_patient') }}" > <i class="fas fa-user-edit fa-sm"></i> </a> 
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
</div>
@endsection
