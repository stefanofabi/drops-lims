@extends('administrators/settings/index')

@section('title')
{{ trans('nomenclators.create_nomenclator') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/nomenclators/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-plus"></i> {{ trans('nomenclators.create_nomenclator') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('nomenclators.nomenclators_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/nomenclators/store') }}">
    @csrf

    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label for="name"> {{ trans('nomenclators.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>
                    
            <small id="nameHelp" class="form-text text-muted"> {{ trans('nomenclators.name_help') }} </small>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection