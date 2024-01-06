@extends('administrators/settings/index')

@section('title')
{{ trans('billing_periods.create_billing_period') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/billing_periods/index') }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-calendar-plus"></i> {{ trans('billing_periods.create_billing_period') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('billing_periods.billing_periods_create_message') }}
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/billing_periods/store') }}">
    @csrf

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="name"> {{ trans('billing_periods.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>
                    
            <small id="nameHelp" class="form-text text-muted"> {{ trans('billing_periods.name_help') }} </small>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="start_date"> {{ trans('billing_periods.start_date') }} </label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date') }}" aria-describedby="startDateHelp" required>
                        
                <small id="startDateHelp" class="form-text text-muted"> {{ trans('billing_periods.start_date_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="end_date"> {{ trans('billing_periods.end_date') }} </label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date') }}" aria-describedby="endDateHelp" required>
                        
                <small id="endDateHelp" class="form-text text-muted"> {{ trans('billing_periods.end_date_help') }} </small>
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection