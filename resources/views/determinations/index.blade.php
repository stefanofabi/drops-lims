@extends('determinations/determinations')

@section('results')
@if (!sizeof($determinations))
	<div class="col-md-12"> {{ trans('forms.no_results') }}</div>
@else 

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('determinations.code') }} </th>
				<th> {{ trans('determinations.determination') }} </th>
				<th class="text-right"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($determinations as $determination)
			<tr>
				<td> {{ $determination->code }} </td>
				<td> {{ $determination->name }} </td>

				<td class="text-right">
					<a href="{{ route('determinations/show', [$determination->id]) }}" class="btn btn-info btn-sm" title="{{ trans('determinations.show_determination') }}" > <i class="fas fa-eye fa-sm"></i> </a> 
					<a href="{{ route('determinations/destroy', [$determination->id]) }}" class="btn btn-info btn-sm" title="{{ trans('determinations.destroy_determination') }}"> <i class="fas fa-trash fa-sm"></i> </a>
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
