@extends('administrators/default-template')

@section('js')

<script type="text/javascript">

	$(document).ready(function() {
        // Select a nomenclator from list
        $("#nomenclator_id").val("{{ old('nomenclator_id') }}");
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
		<a class="nav-link" href=""> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('determinations.add_nbu') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
<i class="fas fa-syringe"></i> {{ trans('determinations.create_determination') }}
@endsection


@section('content')
<form method="post" action="{{ route('administrators/determinations/store') }}">
	@csrf

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
		</div>

		<select id="nomenclator_id" class="form-control input-sm @error('nomenclator_id') is-invalid @enderror" name="nomenclator_id" required>
			<option value=""> {{ trans('forms.select_option') }} </option>
			@foreach ($nomenclators as $nomenclator)
			<option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }} </option>
			@endforeach
		</select>

		@error('nomenclator_id')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>
	
	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.code') }} </span>
		</div>

		<input type="number" class="form-control @error('code') is-invalid @enderror" name="code" min="0" value="{{ old('code') }}" required>

		@error('code')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.name') }} </span>
		</div>

		<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

		@error('name')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.position') }} </span>
		</div>

		<input type="number" class="form-control @error('position') is-invalid @enderror" name="position" min="1" value="{{ old('position') ? : '1' }}" required>

		@error('position')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
		</div>

		<input type="number" class="form-control @error('biochemical_unit') is-invalid @enderror" name="biochemical_unit" min="0" step="0.01" value="{{ old('biochemical_unit') ? : '0.00' }}" required>

		@error('biochemical_unit')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>

	<div class="float-right mt-4">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


