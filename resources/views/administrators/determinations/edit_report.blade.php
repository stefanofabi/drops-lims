@extends('administrators/default-template')

@section('title')
{{ trans('determinations.edit_report') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">
	@if (sizeof($errors) > 0)
	$(document).ready(function() {
		enableSubmitForm();
    });
	@endif

	function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');
		$("textarea").removeAttr('readonly');

		$("#submitButton").removeAttr('disabled');
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

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-warning fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-warning btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('determinations.edit_report_notice') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/update', $determination->id) }}">
    @csrf
    {{ method_field('PUT') }}

	<input type="hidden" name="code" value="{{ $determination->code }}">
	<input type="hidden" name="name" value="{{ $determination->name }}">
	<input type="hidden" name="position" value="{{ $determination->position }}">
	<input type="hidden" name="biochemical_unit" value="{{ $determination->biochemical_unit }}">

    <div class="mt-3">
		<div class="input-group mt-2">
			<span class="input-group-text"> {{ trans('reports.javascript') }} </span>

			<textarea maxlength="1000" class="form-control" rows="10" name="javascript" readonly>{{ old('javascript') ?? $determination->javascript }}</textarea>
		</div>

		<div class="input-group mt-2">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>

			<textarea maxlength="2000" class="form-control" rows="10" name="report" readonly>{{ old('report') ?? $determination->report }}</textarea>
		</div>
	</div>
    
	<input type="submit" class="btn btn-lg btn-primary mt-3" id="submitButton" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection
