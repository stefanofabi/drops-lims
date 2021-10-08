@extends('administrators/default-template')

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
    {{ trans('prescribers.create_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-user-md"></i> {{ trans('prescribers.create_prescriber') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/prescribers/store') }}">
	@csrf

	<div class="col-10">
        <h4><i class="fas fa-book"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
            </div>

            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.email') }} </span>
            </div>

            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="provincial_enrollment" min="0" value="{{ old('provincial_enrollment') }}">

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
            </div>
            <input type="text" class="form-control" name="national_enrollment" min="0" value="{{ old('national_enrollment') }}">
        </div>
	</div>

	<input type="submit" style="display: none" id="submit-button">
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