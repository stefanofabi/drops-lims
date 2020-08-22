@extends('administrators/patients/patients')

@section('messages')
	<div class="alert alert-{{ $type }} alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>

		<p>
			<strong> 
				@if ($type == 'success') 
					{{ trans('patients.success_restore') }}        			
				@else
					{{ trans('patients.danger_restore') }}
				@endif
			</strong> 
		</p>

		<ul>
			<li>
				@if ($type == 'success') 
				<a href="{{ route('administrators/patients/show', $patient_id) }}"> {{ trans('patients.success_restore_message') }} </a>			     	
				@else
					{{ trans('patients.danger_restore_message') }}
				@endif
			</li>  
		</ul>
	</div>
@endsection