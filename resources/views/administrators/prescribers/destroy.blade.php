@extends('administrators/prescribers/prescribers')

@section('js')
	<script type="text/javascript">
		function restore_prescriber() {
		    if (confirm('{{ trans("forms.confirm") }}')) {
		    	var form = document.getElementById('restore_prescriber');
		    	form.submit();
		    }
		}
	</script>
@endsection

@section('messages')
	<div class="alert alert-{{ $type }} alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>

		<p>
			<strong> 
				@if ($type == 'success') 
				{{ trans('prescribers.success_destroy') }}        			
				@else
				{{ trans('prescribers.danger_destroy') }}
				@endif
			</strong> 
		</p>

		<ul>
			@if ($type == 'success') 
			<li> 
				<a href="#" onclick="restore_prescriber()"> {{ trans('prescribers.success_destroy_message') }} </a> 

				<form method="POST" id="restore_prescriber" action="{{ route('administrators/prescribers/restore', $prescriber_id) }}">
					@csrf
					@method('PATCH')
				</form>
			</li>       			
			@else
			{{ trans('prescribers.danger_destroy_message') }}
			@endif
		</ul>
	</div>
@endsection