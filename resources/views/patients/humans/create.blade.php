@extends('patients/create')

@section('content')
<form method="post" action="{{ route('patients/humans/store') }}">
	@csrf
	<div class="card">
		<div class="card-header">
			<h4><i class="fas fa-toolbox"></i> {{ trans('patients.complete_shunt') }} </h4>
		</div>
		<div class="card-body">
			<div class="input-group mb-6 col-md-6">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.shunt') }} </span>
				</div>
					<select class="form-control" name="shunt" required>
						<option value=""> {{ trans('patients.select_shunt') }} </option>
						@foreach ($shunts as $shunt)
						<option value="{{ $shunt->id }}"> {{ $shunt->name }}</option>
						@endforeach
					</select>
			</div>
		</div>
	</div>

	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-id-card"></i> {{ trans('patients.complete_personal_data') }} </h4>
		</div>

		<div class="card-body">

			<div class="input-group mb-6 col-md-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.dni') }} </span>
				</div>
				<input type="number" class="form-control" name="dni">
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.surname') }} </span>
				</div>
				<input type="text" class="form-control" name="surname" required>

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.name') }} </span>
				</div>
				<input type="text" class="form-control" name="name" required>
			</div>

			<div class="input-group mb-6 col-md-9 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.home_address') }} </span>
				</div>
				<input type="text" class="form-control" name="home_address">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.city') }} </span>
				</div>
				<input type="text" class="form-control" name="city">
			</div>

			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.sex') }} </span>
				</div>

				<select class="form-control input-sm" name="sex" required>
					<option value=""> {{ trans('patients.select_sex') }} </option>
					<option value="F"> {{ trans('patients.female') }} </option>
					<option value="M"> {{ trans('patients.male') }} </option>
				</select>
			</div>


			<div class="input-group mb-6 col-md-6 input-form" style="margin-top: 1%">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
				</div>

				<input type="date" class="form-control" name="birth_date">
			</div>

		</div>
	</div>

		<div class="float-right">
			<button type="submit" class="btn btn-primary">
				<span class="fas fa-save"></span> {{ trans('patients.save') }}
			</button>
		</div>	
</form>
@endsection