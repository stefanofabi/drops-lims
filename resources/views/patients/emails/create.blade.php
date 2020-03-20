@extends('default-template')

@section('title')
{{ trans('emails.add_email') }}
@endsection 

@section('active_patients', 'active')

@section('menu-title')
{{ trans('patients.menu') }}
@endsection

@section('menu')
@include('patients/edit_menu')
@endsection

@section('content-title')
<i class="fas fa-at"></i> {{ trans('emails.add_email') }}
@endsection


@section('content')
<form method="post" action="{{ route('patients/emails/store') }}">
	@csrf

	<input type="hidden" class="form-control" name="id" value="{{ $id }}">

	<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('emails.email') }} </span>
		</div>

		<input type="email" class="form-control" name="email" required>
	</div>


	<div class="float-right" style="margin-top: 1%">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>	
</form>
@endsection	


