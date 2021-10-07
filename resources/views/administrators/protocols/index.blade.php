@extends('administrators/protocols/protocols')

@section('results')
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('protocols.protocol_number') }} </th>
				<th> {{ trans('patients.patient') }} </th>
				<th> {{ trans('protocols.completion_date') }} </th>
				<th> {{ trans('protocols.type') }} </th>
				<th class="text-end"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($protocols as $protocol)
			<tr>
				<td> 
					{{ $protocol->id }} 

					@if (date('Y-m-d') == $protocol->completion_date) 
						<span class="badge bg-success bg-sm">New</span>
					@endif 
				</td>

				<td> {{ $protocol->patient }} </td>
				<td> @if ($protocol->completion_date) {{ date('d/m/Y', strtotime($protocol->completion_date)) }} @endif</td>
				<td> 
					@if ($protocol->type == 'our') 
						<span class="badge bg-primary">Our</span>
					@else 
						<span class="badge bg-secondary">Derived</span>
					@endif 
				</td>

				<td class="text-end">
					@if ($protocol->type == 'our')
						<a href="{{ route('administrators/protocols/our/edit', [$protocol->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_protocol') }}" > <i class="fas fa-edit fa-sm"></i> </a> 
					@else 
						<a href="" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_protocol') }}" > <i class="fas fa-edit fa-sm"></i> </a> 
					@endif

					<a href="" class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_protocol') }}"> <i class="fas fa-trash fa-sm"></i> </a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>

	{!! $paginate !!}
@endsection
