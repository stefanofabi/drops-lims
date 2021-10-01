@extends('administrators/prescribers/prescribers')

@section('js')
@parent 

<script type="text/javascript">
	function destroy_prescriber(form_id){
		if (confirm('{{ trans("forms.confirm") }}')) {
		    var form = document.getElementById('destroy_prescriber_'+form_id);
		    form.submit();
		}
	}
</script>
@endsection

@section('results')
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th> {{ trans('prescribers.prescriber') }} </th>
			<th> {{ trans('prescribers.provincial_enrollment') }} </th>
			<th> {{ trans('prescribers.national_enrollment') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($prescribers as $prescriber)
			<tr>
				<td> {{ $prescriber->full_name }} </td>
				<td> {{ $prescriber->provincial_enrollment }} </td>
				<td> {{ $prescriber->national_enrollment }} </td>

				<td class="text-end">
						<a href="{{ route('administrators/prescribers/edit', $prescriber->id) }}" class="btn btn-info btn-sm" title="{{ trans('prescribers.edit_prescriber') }}" > <i class="fas fa-user-edit fa-sm"></i> </a>

						<a class="btn btn-info btn-sm" title="{{ trans('prescribers.destroy_prescriber') }}" onclick="destroy_prescriber('{{ $prescriber->id }}')" >
							<i class="fas fa-user-slash fa-sm"></i>
						</a>

						<form id="destroy_prescriber_{{ $prescriber->id }}" method="POST" action="{{ route('administrators/prescribers/destroy', $prescriber->id) }}">
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
