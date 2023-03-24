@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.edit_social_work') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/payments/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('payment_social_works.payments')}} </a>
		</li>

	    <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('plans.plans')}} </a>
		</li>

        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-pen-to-square"></i> {{ trans('social_works.edit_social_work') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('social_works.social_works_edit_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/update', ['id' => $social_work->id]) }}">
    @csrf
    @method('PUT')

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $social_work->name  }}" aria-describedby="nameHelp" required>
                        
            <small id="nameHelp" class="form-text text-muted"> {{ trans('social_works.name_help') }} </small>
        </div>

        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.acronym') }} </label>
            <input type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" id="acronym" value="{{ old('acronym') ?? $social_work->acronym }}" aria-describedby="acronymHelp" required>
                        
            <small id="acronymHelp" class="form-text text-muted"> {{ trans('social_works.acronym_help') }} </small>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection