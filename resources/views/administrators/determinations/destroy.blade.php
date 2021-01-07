@extends('administrators/determinations/determinations')

@section('js')
    @parent

	@if ($type == 'success')
		<script type="text/javascript">
			function restore_determination() {
			    if (confirm('{{ trans("forms.confirm") }}')) {
			    	var form = document.getElementById('restore_determination');
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
					{{ trans('determinations.success_destroy') }}
				@else
					{{ trans('determinations.danger_destroy') }}
				@endif
			</strong>
		</p>

		<ul>
			<li>
				@if ($type == 'success')
					<a href="#" onclick="restore_determination()"> {{ trans('determinations.success_destroy_message') }} </a>

					<form method="POST" id="restore_determination" action="{{ route('administrators/determinations/restore', ['id' => $determination_id]) }}">
						@csrf
						@method('PATCH')
					</form>
				@else
					{{ trans('determinations.danger_destroy_message') }}
				@endif
			</li>
		</ul>
	</div>
@endsection
