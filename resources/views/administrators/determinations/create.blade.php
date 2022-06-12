@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
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

@section('content')
<form method="post" action="{{ route('administrators/determinations/store') }}">
	@csrf

	<div class="col-10 mt-3">
		<h4><i class="fas fa-book-medical"></i> {{ trans('determinations.determination_data') }} </h4>
		<hr class="col-6">

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
			</div>

			<select class="form-select input-sm @error('nomenclator_id') is-invalid @enderror" name="nomenclator_id" id="nomenclator"  required>
				<option value=""> {{ trans('forms.select_option') }} </option>

				@foreach ($nomenclators as $nomenclator)
				<option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }} </option>
				@endforeach
			</select>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.code') }} </span>
			</div>

			<input type="number" class="form-control @error('code') is-invalid @enderror" name="code" min="0" value="{{ old('code') }}" required>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.name') }} </span>
			</div>

			<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.position') }} </span>
			</div>

			<input type="number" class="form-control @error('position') is-invalid @enderror" name="position" min="1" value="{{ old('position') }}" required>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
			</div>

			<input type="number" class="form-control @error('biochemical_unit') is-invalid @enderror" name="biochemical_unit" min="0" step="0.01" value="{{ old('biochemical_unit') }}" required>
		</div>

		<div class="input-group mt-2">
			<span class="input-group-text"> {{ trans('reports.javascript') }} </span>

			<textarea maxlength="1000" class="form-control" rows="10" name="javascript">{{ old('javascript') }}</textarea>
		</div>

		<div class="input-group mt-2">
			<span class="input-group-text"> {{ trans('reports.report') }} </span>

			<textarea maxlength="2000" class="form-control" rows="10" name="report">{{ old('report') }}</textarea>
		</div>
	</div>

	<input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection
