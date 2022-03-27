@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.edit_social_work') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
	        <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('plans.plans')}} </a>
			</li>

            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/payments/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('payment_social_works.payments')}} </a>
			</li>

            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('social_works.edit_social_work') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/update', ['id' => $social_work->id]) }}">
    @csrf
    @method('PUT')

    <div class="col-9 mt-3">
        <div class="input-group input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $social_work->name }}" required>
        </div>
    </div>

    <div class="col-9 mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.acronym') }} </span>
            </div>

            <input type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" value="{{ old('acronym') ?? $social_work->acronym }}" required>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection