@extends('administrators/settings/index')

@section('title')
{{ trans('system_parameters.edit_system_parameters') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link @if ($category == 'General') active @endif" href="{{ route('administrators/settings/system_parameters/edit', ['category' => 'General']) }}"> General </a>
            <a class="nav-link @if ($category == 'PDF Protocol') active @endif" href="{{ route('administrators/settings/system_parameters/edit', ['category' => 'PDF Protocol']) }}"> Protocol PDF </a>
			<a class="nav-link @if ($category == 'Email') active @endif" href="{{ route('administrators/settings/system_parameters/edit', ['category' => 'Email']) }}"> Email </a>

            <a class="nav-link" href="{{ route('administrators/settings/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-sliders"></i> {{ trans('system_parameters.edit_system_parameters') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('system_parameters.system_parameters_edit_content_message') }}
</p>
@endsection

@section('content')
<div class="mt-4">
    <h2> {{ $category }} </h2>
    <hr class="col-6">
</div>

<form method="post" action="{{ route('administrators/settings/system_parameters/update') }}">
    @csrf
    @method('PUT')

    @forelse ($system_parameters as $system_parameter)
    <div class="col-md-9 mt-3">
        <div class="form-group">
            <label class="fw-bold" for="{{ $system_parameter->name }}"> {{ $system_parameter->name }} </label>
            <input type="text" class="form-control @error($system_parameter->key) is-invalid @enderror" name="{{ $system_parameter->key }}" id="{{ $system_parameter->key }}" value="{{ old($system_parameter->key) ?? $system_parameter->value }}" aria-describedby="{{ $system_parameter->key }}_HELP" required>
                        
            <small id="{{ $system_parameter->key }}_HELP" class="form-text text-muted"> {{ $system_parameter->description }}</small>
        </div>
    </div>
    @empty
    <p class="mt-3 text-danger"> {{ trans('system_parameters.no_system_parameters_found') }} </p>
    @endforelse

    <input type="submit" class="btn btn-lg btn-danger mt-4" value="{{ trans('forms.save') }}">
</form>
@endsection