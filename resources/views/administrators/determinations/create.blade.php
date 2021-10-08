@extends('administrators/default-template')

@section('js')
<script type="text/javascript">
    function submitForm() 
	{
        let submitButton = $('#submit-button');
        submitButton.click();
    }

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

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href=""> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('determinations.add_nomenclator') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-syringe"></i> {{ trans('determinations.create_determination') }}
@endsection


@section('content')
<form method="post" action="{{ route('administrators/determinations/store') }}">
	@csrf

	<div class="col-10">
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
