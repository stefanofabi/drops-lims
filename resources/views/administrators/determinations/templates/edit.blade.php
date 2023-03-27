@extends('administrators/default-template')

@section('title')
{{ trans('templates.edit_template') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="module">
	@if (sizeof($errors) > 0)
	$(document).ready(function() {
		enableSubmitForm();
    });
	@endif
</script>

<script type="text/javascript">
	function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');
		$("input").removeAttr('disabled');
		$("textarea").removeAttr('disabled');
	}
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/edit', ['id' => $determination->id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
    <i class="fas fa-edit"></i> {{ trans('templates.edit_template') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	{{ trans('templates.templates_edit_message') }}
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-warning fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-warning btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('templates.edit_template_notice') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/templates/update', ['id' => $determination->id]) }}">
    @csrf
    {{ method_field('PUT') }}

	<div class="form-group mt-2">
		<label for="javascript"> {{ trans('templates.javascript') }} </label>
		<textarea maxlength="1000" class="form-control" rows="10" name="javascript" id="javascript" aria-describedby="javascriptHelp" placeholder='<script> $(document).ready(function() {  your code }); </script>' disabled>{{ old('javascript') ?? $determination->javascript }}</textarea>
		
		<small id="javascriptHelp" class="form-text text-muted"> {{ trans('templates.javascript_help') }} </small>
	</div>

	<div class="form-group mt-2">
		<label for="template"> {{ trans('templates.template') }} </label>
		<textarea maxlength="2000" class="form-control" rows="10" name="template" id="template" aria-describedby="templateHelp" placeholder='<p> <b> Determination name </b> </p> <p> <input type="number" name="result[]"> </p>' disabled>{{ old('template') ?? $determination->template }}</textarea>
		
		<small id="templateHelp" class="form-text text-muted"> {{ trans('templates.template_help') }} </small>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection