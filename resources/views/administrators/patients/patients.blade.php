@extends('administrators/default-filter')

@section('title')
{{ trans('patients.patients') }}
@endsection

@section('main-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.patients') }}
@endsection

@section('create-text')
<span class="fas fa-user-plus" ></span> {{ trans('patients.create_patient') }}
@endsection

@section('create-href')
{{ route('administrators/patients/create', ['type' => 'human']) }}
@endsection

@section('active_patients', 'active')

@section('action_page')
{{ route('administrators/patients/index') }}
@endsection

@section('filters')
<!-- Patient type -->
<div class="btn-group mt-3" role="group" aria-label="Patients filters">
    <input type="radio" class="btn-check" id="animalType" name="type" value="animal" required>
    <label class="btn btn-outline-primary" for="animalType"> {{ trans('patients.animal') }}</label>

    <input type="radio" class="btn-check" id="humanType" name="type" value="human" required>
    <label class="btn btn-outline-primary" for="humanType"> {{ trans('patients.human') }} </label>

    <input type="radio" class="btn-check" id="industrialType" name="type" value="industrial" required>
    <label class="btn btn-outline-primary" for="industrialType"> {{ trans('patients.industrial') }} </label>
</div>

<!-- Filter by keys -->
<div class="form-group row">
    <div class="mt-3 col-md-6">
        <input type="text" class="form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
    </div>

    <div class="mt-3 col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
        </div>
</div>
@endsection

@section('action_page')
{{ route('administrators/patients/index') }}
@endsection
