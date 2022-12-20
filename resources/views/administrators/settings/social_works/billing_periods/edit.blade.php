@extends('administrators/settings/index')

@section('js')
<script type="text/javascript">
    function submitForm() 
	{
        let submitButton = $('#submit-button');
        submitButton.click();
    }
</script>
@endsection

@section('title')
    {{ trans('billing_periods.edit_billing_period') }}
@endsection

@section('content-title')
    <i class="fas fa-plus"> </i> {{ trans('billing_periods.edit_billing_period') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    The billing periods specify unique periods in the year in which the practices performed on all patients in that period are detailed.
</p>
@endsection

@section('content')
    <form method="post" action="{{ route('administrators/settings/social_works/billing_periods/update', ['id' => $billing_period->id]) }}">
        @csrf
        @method('PUT')

        <div class="col-md-6 mt-3">
            <div class="form-group mt-2">
                <label for="name"> {{ trans('billing_periods.name') }} </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $billing_period->name }}" aria-describedby="nameHelp" required>
                        
                <small id="nameHelp" class="form-text text-muted"> Name to identify a billing period and assign it to a protocol </small>
            </div>

            <div class="form-group mt-2">
                <label for="start_date"> {{ trans('billing_periods.start_date') }} </label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date') ?? $billing_period->start_date }}" aria-describedby="startDateHelp" required>
                        
                <small id="startDateHelp" class="form-text text-muted"> Start date on which the billing period begins </small>
            </div>

            <div class="form-group mt-2">
                <label for="end_date"> {{ trans('billing_periods.end_date') }} </label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date') ?? $billing_period->end_date }}" aria-describedby="endDateHelp" required>
                        
                <small id="endDateHelp" class="form-text text-muted"> End date on which the billing period begins </small>
            </div>
        </div>

        <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
    </form>
@endsection

@section('content-footer')
<div class="card-footer">
	<div class="float-end">
		<button type="submit" class="btn btn-primary" onclick="submitForm()">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>
</div>
@endsection