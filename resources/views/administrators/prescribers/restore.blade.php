@extends('administrators/prescribers/prescribers')

@section('messages')
	<div class="alert alert-{{ $type }} alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>

		<p>
			<strong> 
				@if ($type == 'success') 
					{{ trans('prescribers.success_restore') }}        			
				@else
					{{ trans('prescribers.danger_restore') }}
				@endif
			</strong> 
		</p>

		<ul>
			<li> 
				@if ($type == 'success') 
					<a href="{{ route('administrators/prescribers/show', $prescriber_id) }}"> 
							{{ trans('prescribers.success_restore_message') }} 
					</a>        			
				@else
					{{ trans('prescribers.danger_restore_message') }}
				@endif
			</li>
		</ul>
	</div>
@endsection