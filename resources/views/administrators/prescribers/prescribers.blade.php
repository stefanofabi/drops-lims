@extends('administrators/default-filter')

@section('title')
{{ trans('prescribers.prescribers') }}
@endsection

@section('main-title')
<i class="fas fa-user-md"></i> {{ trans('prescribers.prescribers') }}
@endsection

@section('create-href')
{{ route('administrators/prescribers/create') }}
@endsection

@section('create-text')
<span class="fas fa-briefcase-medical" ></span> {{ trans('prescribers.create_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('action_page')
{{ route('administrators/prescribers/index') }}
@endsection

@section('filters')
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
