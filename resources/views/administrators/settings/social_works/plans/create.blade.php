@extends('administrators/settings/index')

@section('js')
<script type="text/javascript">
    $(document).ready(function () 
    {
        // Select a nomenclator from list
        $("#nomenclator").val("{{ old('nomenclator_id') }}");
    });
</script>
@endsection

@section('title')
{{ trans('plans.create_plan') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-plus"> </i> {{ trans('plans.create_plan') }}
@endsection

@section('content')
<div class="input-group mt-3 col-md-9 input-form">
    <div class="input-group-prepend">
        <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
    </div>

    <input type="text" class="form-control" value="{{ $social_work->name }}" readonly>
</div>

<form method="post" action="{{ route('administrators/settings/social_works/plans/store') }}">
    @csrf

    <input type="hidden" name="social_work_id" value="{{ $social_work->id }}">

    <div class="input-group mt-2 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('nomenclators.name') }} </span>
        </div>

        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>
    </div>

    <div class="input-group mt-2 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('nomenclators.nomenclator') }} </span>
        </div>

        <select id="nomenclator" class="form-select" name="nomenclator_id">
            <option value=""> {{ trans('forms.select_option') }}</option>
            @foreach ($nomenclators as $nomenclator)
            <option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-group mt-2 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('social_works.nbu_price') }} </span>
        </div>

        <input type="number" step="0.01" class="form-control @error('nbu_price') is-invalid @enderror" name="nbu_price" value="{{ old('nbu_price') }}" required>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection