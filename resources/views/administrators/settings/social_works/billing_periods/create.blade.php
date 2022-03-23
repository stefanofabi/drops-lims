@extends('administrators/settings/index')

@section('title')
{{ trans('billing_periods.create_billing_period') }}
@endsection

@section('content-title')
<i class="fas fa-plus"> </i> {{ trans('billing_periods.create_billing_period') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/billing_periods/store') }}">
    @csrf

    <div class="col-9 mt-3">
        <div class="input-group input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('billing_periods.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')  }}" required>
        </div>

        <div class="input-group input-form mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('billing_periods.start_date') }} </span>
            </div>

            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
        </div>

        <div class="input-group input-form mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('billing_periods.end_date') }} </span>
            </div>

            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
        </div>
    </div>
    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection