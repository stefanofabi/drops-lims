@extends('administrators/default-filter')

@section('title')
{{ trans('patients.patients') }}
@endsection

@section('main-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.patients') }}
@endsection

@section('create-href')
{{ route('administrators/patients/create') }}
@endsection

@section('create-text')
<span class="fas fa-user-plus" ></span> {{ trans('patients.create_patient') }}
@endsection

@section('active_patients', 'active')

@section('action_page')
{{ route('administrators/patients/load') }}
@endsection

@section('filters')
<!-- Patient type -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" id="tipoAnimal" name="type" value="animal" required>
    <label class="btn btn-outline-primary" for="tipoAnimal"> {{ trans('patients.animal') }}</label>

    <input type="radio" class="btn-check" id="tipoHumano" name="type" value="human" required>
    <label class="btn btn-outline-primary" for="tipoHumano"> {{ trans('patients.human') }} </label>

    <input type="radio" class="btn-check" id="tipoIndustrial" name="type" value="industrial" required>
    <label class="btn btn-outline-primary" for="tipoIndustrial"> {{ trans('patients.industrial') }} </label>
</div>

<!-- Filter by keys -->
<div class="form-group row">
    <div class="mt-2 col-md-6">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
    </div>

    <div class="mt-2 col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
        </div>
</div>
@endsection

@section('action_page')
{{ route('administrators/patients/load') }}
@endsection
