<div id="phones_messages">
</div>

<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('phones.phones') }} </span>
	</div>

	<select class="form-control input-sm col-md-6" id="phone">
		<option value=""> {{ trans('forms.select_option') }}</option>

		@foreach ($patient->phones as $phone)
		<option value="{{ $phone->id }}"> {{ $phone->phone }}</option>
		@endforeach
	</select>

	<div class="ml-2">
		<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editPhone" onclick="return editPhone()">
			<span class="fas fa-edit"></span>
		</button>

		<button type="button" class="btn btn-info btn-md" onclick="return destroyPhone()">
			<span class="fas fa-trash"></span>
		</button>
	</div>
</div>
