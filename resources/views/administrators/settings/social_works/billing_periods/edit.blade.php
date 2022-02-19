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

@section('content')
    <form method="post" action="{{ route('administrators/settings/social_works/billing_periods/update', ['id' => $billing_period->id]) }}">
        @csrf
        @method('PUT')
        
        <div class="col-9">
            <div class="input-group mt-2 mb-1 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.name') }} </span>
                </div>

                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $billing_period->name  }}" required>
            </div>

            <div class="input-group mt-2 mb-1 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.start_date') }} </span>
                </div>

                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') ?? $billing_period->start_date }}" required>
            </div>

            <div class="input-group mt-2 mb-1 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.end_date') }} </span>
                </div>

                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') ?? $billing_period->end_date }}" required>
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