@extends('administrators/default-template')

@section('js')
<script type="module">
	$(document).ready(function() 
	{
        // Select a nomenclator from list
        $("#nomenclator").val("{{ old('nomenclator_id') }}");
    });
</script>
@endsection

@section('title')
{{ trans('determinations.create_determination') }}
@endsection

@section('active_determinations', 'active')

@section('content-title')
<i class="fas fa-syringe"></i> {{ trans('determinations.create_determination') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
	{{ trans('determinations.determinations_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/determinations/store') }}">
	@csrf

	<div class="mt-4">
		<h4><i class="fas fa-book-medical"></i> {{ trans('determinations.determination_data') }} </h4>
		<hr class="col-6">
	</div>
	
	<div class="col-md-6">
		<div class="form-group mt-2">
			<label for="nomenclator"> {{ trans('nomenclators.nomenclator') }} </label>
			<select class="form-select input-sm @error('nomenclator_id') is-invalid @enderror" name="nomenclator_id" id="nomenclator" aria-describedby="nomenclatorHelp" required>
				<option value=""> {{ trans('forms.select_option') }} </option>

				@foreach ($nomenclators as $nomenclator)
				<option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }} </option>
				@endforeach
			</select>

			<small id="nomenclatorHelp" class="form-text text-muted"> {{ trans('determinations.nomenclator_help') }} </small>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="code"> {{ trans('determinations.code') }} </label>
				<input type="number" class="form-control @error('code') is-invalid @enderror" name="code" id="code" min="0" value="{{ old('code') }}" aria-describedby="codeHelp" required>

				<small id="codeHelp" class="form-text text-muted"> {{ trans('determinations.code_help') }} </small>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="name"> {{ trans('determinations.name') }} </label>
				<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>

				<small id="nameHelp" class="form-text text-muted"> {{ trans('determinations.name_help') }} </small>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="position"> {{ trans('determinations.position') }} </label>
				<input type="number" class="form-control @error('position') is-invalid @enderror" name="position" id="position" min="1" value="{{ old('position') }}" aria-describedby="positionHelp" required>

				<small id="positionHelp" class="form-text text-muted"> {{ trans('determinations.position_help') }} </small>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group mt-2">
				<label for="biochemical_unit"> {{ trans('determinations.biochemical_unit') }} </label>
				<input type="number" class="form-control @error('biochemical_unit') is-invalid @enderror" name="biochemical_unit" id="biochemical_unit" min="0" step="0.01" value="{{ old('biochemical_unit') }}" aria-describedby="biochemicalUnitHelp" required>

				<small id="biochemicalUnitHelp" class="form-text text-muted"> {{ trans('determinations.biochemical_unit_help') }} </small>
			</div>
		</div>			
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection
