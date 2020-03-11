@extends('prescribers/prescribers')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('prescribers.prescriber') }} </th>
				<th> {{ trans('prescribers.provincial_enrollment') }} </th>
				<th> {{ trans('prescribers.national_enrollment') }} </th>  
				<th class="text-right"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($prescribers as $prescriber)
			<tr>
				<td> {{ $prescriber->full_name }} </td>
				<td> {{ $prescriber->provincial_enrollment }} </td>
				<td> {{ $prescriber->national_enrollment }} </td>

				<td class="text-right">
					<a href="{{ route('prescribers/show', [$prescriber->id]) }}" class="btn btn-info btn-sm" title="{{ trans('prescribers.show_prescriber') }}" > <i class="fas fa-eye fa-sm"></i> </a> 
					<a href="{{ route('prescribers/destroy', [$prescriber->id]) }}" class="btn btn-info btn-sm" title="{{ trans('prescribers.destroy_prescriber') }}"> <i class="fas fa-user-slash fa-sm"></i> </a>
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
