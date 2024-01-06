@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.create_social_work') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-heart-circle-plus"></i> {{ trans('social_works.create_social_work') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('social_works.social_works_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/store') }}">
    @csrf

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>
                        
            <small id="nameHelp" class="form-text text-muted"> {{ trans('social_works.name_help') }} </small>
        </div>

        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.acronym') }} </label>
            <input type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" id="acronym" value="{{ old('acronym') }}" aria-describedby="acronymHelp" required>
                        
            <small id="acronymHelp" class="form-text text-muted"> {{ trans('social_works.acronym_help') }} </small>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection