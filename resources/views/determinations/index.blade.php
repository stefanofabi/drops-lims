@extends('determinations/determinations')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('determinations.code') }} </th>
				<th> {{ trans('determinations.determination') }} </th>
				<th class="text-right"> {{ trans('prescribers.actions') }} </th>
			</tr>

			@foreach ($determinations as $determination)
			<tr>
				<td> {{ $determination->code }} </td>
				<td> {{ $determination->name }} </td>

				<td class="text-right">
					<a href="{{ route('determinations/show', [$determination->id]) }}" class="btn btn-info btn-sm" title="{{ trans('determinations.show_determination') }}" > <i class="fas fa-user-edit fa-sm"></i> </a> 
					<a href="{{ route('determinations/destroy', [$determination->id]) }}" class="btn btn-info btn-sm" title="{{ trans('determinations.destroy_determination') }}"> <i class="fas fa-user-slash fa-sm"></i> </a>
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
