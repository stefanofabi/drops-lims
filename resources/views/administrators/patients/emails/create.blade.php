@extends('administrators/default-template')

@section('title')
{{ trans('emails.add_email') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('menu')
@include('administrators/patients/edit_menu')

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administrators/patients/edit', $patient->id) }}"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
	</li>	
</ul>
@endsection

@section('content-title')
<i class="fas fa-at"></i> {{ trans('emails.add_email') }}
@endsection


@section('content')
<form method="post" action="{{ route('administrators/patients/emails/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="patient_id" value="{{ $patient->id }}">

	<div class="input-group mt-2 col-md-6 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('emails.email') }} </span>
		</div>

		<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>

		@error('email')
        	<span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
        @enderror
	</div>


	<div class="float-right mt-4">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


