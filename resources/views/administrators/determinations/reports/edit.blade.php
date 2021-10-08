@extends('administrators/default-template')

@section('title')
{{ trans('reports.edit_report') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">

	var enableForm = false;	

    $(document).ready(function() 
    {
		@if (sizeof($errors) > 0)
		enableSubmitForm();
		@endif
    });

    function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');
		$("textarea").removeAttr('readonly');

		$("#dangerMessage").removeClass('d-none');
		$("#submitButtonVisible").removeClass('disabled');
		
		enableForm = true;
	}

	function submitForm() 
	{
		if (enableForm) 
		{
			let submitButton = $('#submit-button');
            submitButton.click();
		}
    }

	function confirm_changes()  
	{
		var change = false;
		if (confirm('{{ trans("forms.confirm") }}')){
			change = true;
    	}

    	return change;
	}
</script>
@endsection

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/determinations/edit', ['id' => $report->determination->id]) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-code"></i> {{ trans('reports.edit_report') }}
@endsection


@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('reports.report_blocked') }}
	</div>
@endif

<div id="dangerMessage" class="alert alert-danger d-none">
	<strong>{{ trans('forms.danger') }}!</strong> {{ trans('reports.edit_notice') }}
</div>

<form method="post" action="{{ route('administrators/determinations/reports/update', ['id' => $report->id]) }}" onsubmit="return confirm_changes()">
	@csrf
	{{ method_field('PUT') }}

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.determination') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $report->determination->name }}" disabled>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control" name="name" value="{{ old('name') ?? $report->name }}" readonly>
	</div>

	<div class="input-group mt-2 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>
		</div>

		<textarea class="form-control" rows="10" name="report" style="font-size: 12px" readonly>{{ old('report') ?? $report->report }}</textarea>
	</div>

	<input type="submit" class="d-none" id="submit-button">
</form>
@endsection

@section('content-footer')
<div class="card-footer">
	<div class="float-end">
		<button type="submit" class="btn btn-primary" onclick="submitForm()">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>
</div>
@endsection


