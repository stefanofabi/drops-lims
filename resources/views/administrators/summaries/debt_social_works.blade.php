@extends('administrators.summaries.index')

@section('content')
<div class="mt-3"> 
    <h2> {{ trans('summaries.debt_social_works') }} </h2> 
    {{ trans('summaries.debt_social_works_message') }}
</div>

<form method="post" target="_blank" action="{{ route('administrators/summaries/get_debt_social_works') }}">
    @csrf

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="startDate"> {{ trans('summaries.start_date') }} </label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="startDate" value="{{ date('Y-m-d', strtotime('now - 1 month')) }}" aria-describedby="startDateHelp" required>

            <small id="startDateHelp" class="form-text text-muted"> The date you start filtering</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="endDate"> {{ trans('summaries.end_date') }} </label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="endDate" value="{{ date('Y-m-d') }}" aria-describedby="endDateHelp" required>

            <small id="endDateHelp" class="form-text text-muted"> The date you end filtering </small>
        </div>
    </div>

  <input type="submit" class="btn btn-primary mt-3" value="{{ trans('summaries.generate_summary') }}">
</form>
@endsection