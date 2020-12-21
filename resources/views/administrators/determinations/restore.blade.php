@extends('administrators/determinations/determinations')

@section('messages')
	<div class="alert alert-{{ $type }} alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>

		<p>
			<strong> 
				@if ($type == 'success') 
					{{ trans('determinations.success_restore') }}        			
				@else
					{{ trans('determinations.danger_restore') }}
				@endif
			</strong> 
		</p>

		<ul>
			<li>
				@if ($type == 'success') 
				<a href="{{ route('administrators/determinations/show', $determination_id) }}"> {{ trans('determinations.success_restore_message') }} </a>			     	
				@else
					{{ trans('determinations.danger_restore_message') }}
				@endif
			</li>  
		</ul>
	</div>
@endsection