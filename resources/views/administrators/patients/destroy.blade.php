@extends('administrators/patients/patients')

@section('js')
	@if ($type == 'success') 
		<script type="text/javascript">
			function restore_patient() {
			    if (confirm('{{ trans("forms.confirm") }}')) {
			    	var form = document.getElementById('restore_patient');
			    	form.submit();
			    }
			}
		</script>
	@endif
@append

@section('messages')
	<div class="alert alert-{{ $type }} alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>

		<p>
			<strong> 
				@if ($type == 'success') 
					{{ trans('patients.success_destroy') }}        			
				@else
					{{ trans('patients.danger_destroy') }}
				@endif
			</strong> 
		</p>

		<ul>
			<li>
				@if ($type == 'success') 
					<a href="#" onclick="restore_patient()"> {{ trans('patients.success_destroy_message') }} </a> 

					<form method="POST" id="restore_patient" action="{{ route('administrators/patients/restore', $patient_id) }}">
						@csrf
						@method('PATCH')
					</form>					     			
				@else
					{{ trans('patients.danger_destroy_message') }}
				@endif
			</li>  
		</ul>
	</div>
@endsection