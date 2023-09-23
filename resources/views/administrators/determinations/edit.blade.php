@extends('administrators/default-template')

@section('title')
{{ trans('determinations.edit_determination') }}
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
		$("#nomenclator").attr('disabled', true);
	}
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link @cannot('manage templates') disabled @endcannot" href="{{ route('administrators/determinations/templates/results/edit', ['id' => $determination->id]) }}"> {{ trans('templates.edit_result_template') }} </a>
        </li>

		<li class="nav-item">
            <a class="nav-link @cannot('manage templates') disabled @endcannot" href="{{ route('administrators/determinations/templates/worksheets/edit', ['id' => $determination->id]) }}"> {{ trans('templates.edit_worksheet_template') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
    <i class="fas fa-edit"></i> {{ trans('determinations.edit_determination') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	{{ trans('determinations.determinations_edit_message') }}
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show mt-3">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-primary btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('determinations.determination_blocked') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/update', $determination->id) }}">
    @csrf
    {{ method_field('PUT') }}

	<div class="mt-4">
		<h4><i class="fas fa-book-medical"></i> {{ trans('determinations.determination_data') }} </h4>
		<hr class="col-6">
	</div>

	<div class="col-md-6">
		<div class="form-group mt-2">
			<label for="nomenclator"> {{ trans('nomenclators.nomenclator') }} </label>
			<input type="text" class="form-control" id="nomenclator" value="{{ $determination->nomenclator->name }}" aria-describedby="nomenclatorHelp" disabled>

			<small id="nomenclatorHelp" class="form-text text-muted"> {{ trans('determinations.nomenclator_help') }} </small>
		</div>
	</div>

    <div class="row">
		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="code"> {{ trans('determinations.code') }} </label>
				<input type="number" class="form-control @error('code') is-invalid @enderror" name="code" id="code" min="0" value="{{ old('code') ?? $determination->code }}" aria-describedby="codeHelp" required disabled>

				<small id="codeHelp" class="form-text text-muted"> {{ trans('determinations.code_help') }} </small>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="name"> {{ trans('determinations.name') }} </label>
				<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $determination->name }}" aria-describedby="nameHelp" required disabled>

				<small id="nameHelp" class="form-text text-muted"> {{ trans('determinations.name_help') }} </small>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="position"> {{ trans('determinations.position') }} </label>
				<input type="number" class="form-control @error('position') is-invalid @enderror" name="position" id="position" min="1" value="{{ old('position') ?? $determination->position }}" aria-describedby="positionHelp" required disabled> 

				<small id="positionHelp" class="form-text text-muted"> {{ trans('determinations.position_help') }} </small>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="biochemical_unit"> {{ trans('determinations.biochemical_unit') }} </label>
				<input type="number" class="form-control @error('biochemical_unit') is-invalid @enderror" name="biochemical_unit" id="biochemical_unit" min="0" step="0.01" value="{{ old('biochemical_unit') ?? $determination->biochemical_unit }}" aria-describedby="biochemicalUnitHelp" required disabled>

				<small id="biochemicalUnitHelp" class="form-text text-muted"> {{ trans('determinations.biochemical_unit_help') }} </small>
			</div>
		</div>
	</div>
    
	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}" disabled>
</form>
@endsection
