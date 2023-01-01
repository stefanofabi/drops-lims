@extends('administrators/default-template')

@section('title')
{{ trans('determinations.edit_report') }}
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
    <i class="fas fa-edit"></i> {{ trans('determinations.edit_report') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	This section is very important and with restricted access. Please use extreme caution and attention when making a modification here.
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-warning fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-warning btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('determinations.edit_report_notice') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/update/report', $determination->id) }}">
    @csrf
    {{ method_field('PUT') }}

	<div class="form-group mt-2">
		<label for="javascript"> {{ trans('reports.javascript') }} </label>
		<textarea maxlength="1000" class="form-control" rows="10" name="javascript" id="javascript" aria-describedby="javascriptHelp" placeholder='<script> $(document).ready(function() {  your code }); </script>' disabled>{{ old('javascript') ?? $determination->javascript }}</textarea>
		
		<small id="javascriptHelp" class="form-text text-muted"> Write javascript code to interact with the report. You can for example show warnings, validate fields, etc. </small>
	</div>

	<div class="form-group mt-2">
		<label for="report"> {{ trans('reports.report') }} </label>
		<textarea maxlength="2000" class="form-control" rows="10" name="report" id="report" aria-describedby="reportHelp" placeholder='<b> Determination name </b> <br /> <input type="number" name="result[]">' disabled>{{ old('report') ?? $determination->report }}</textarea>
		
		<small id="reportHelp" class="form-text text-muted"> Write HTML code that will be displayed when reporting a practice or when generating a pdf protocol. <br /> In the input fields you must set the attribute name="result[]" so that the results are loaded into the system. </small>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection
