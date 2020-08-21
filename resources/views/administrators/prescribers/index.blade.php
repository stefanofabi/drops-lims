@extends('administrators/prescribers/prescribers')

@section('js')
    <script type="text/javascript">

	    function load(page) {
	        $("#page" ).val(page);
	        document.all["select_page"].submit();
	     }

		function destroy_prescriber(form_id){
		    if (confirm('{{ trans("forms.confirm") }}')) {
		    	var form = document.getElementById('destroy_prescriber_'+form_id);
		    	form.submit();
		    }
		}

        $(document).ready(function() {
            // Put the filter
            $("#filter" ).val('{{ $request['filter'] }}');
        });   

	</script>
@append

@section('results')
	@if (!sizeof($prescribers))
		<div class="col-md-12"> {{ trans('forms.no_results') }}</div>
	@else 

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
							<a href="{{ route('administrators/prescribers/show', $prescriber->id) }}" class="btn btn-info btn-sm float-left" title="{{ trans('prescribers.show_prescriber') }}" > <i class="fas fa-eye fa-sm"></i> </a> 

							<form id="destroy_prescriber_{{ $prescriber->id }}" method="POST" action="{{ route('administrators/prescribers/destroy', $prescriber->id) }}">
								@csrf
								@method('DELETE')

								<a class="btn btn-info btn-sm" title="{{ trans('prescribers.destroy_prescriber') }}" onclick="destroy_prescriber('{{ $prescriber->id }}')" >  
									<i class="fas fa-user-slash fa-sm"></i> 
								</a> 						
							</form>
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
