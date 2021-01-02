@extends('patients/default-filter')

@section('title')
{{ trans('home.results') }}
@endsection

@section('active_results', 'active')

@section('main-title')
<i class="fas fa-file-medical"></i> {{ trans('home.results') }}
@endsection

@section('create-href')
{{ route('patients/family_members/create') }}
@endsection

@section('create-text')
<span class="fas fa-user-plus" ></span> {{ trans('patients.add_family_member') }}
@endsection

@section('filters')

    <div class="col form-group row col-md-6">
        <span for="inputState">{{ trans('forms.initial_date') }}</span>
        <input type="date" class="form-control" id="initial_date" name="initial_date" value="{{ $initial_date }}" required>
    </div>

    <div class="col form-group row col-md-6">
        <span for="inputState">{{ trans('forms.ended_date') }}</span>
        <input type="date" class="form-control" id="ended_date" name="ended_date" value="{{ $ended_date }}" required>
    </div>

    <div class="col form-group row col-md-6">
        <span for="inputState">{{ trans('patients.patient') }}</span>
        <select class="form-control" id="patient" name="patient_id" required>
            <option value="">{{ trans('forms.select_option') }}</option>
            @foreach ($family_members as $family_member)
                <option value="{{ $family_member->patient->id }}"> {{ $family_member->patient->full_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Filter by keys -->
    <div class="form-group row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-info">
                <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
            </div>
    </div>
@endsection

@section('action_page')
{{ route('patients/protocols/index') }}
@endsection
