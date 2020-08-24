<div id="emails_messages">
</div>

<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('emails.emails') }} </span>
	</div>

	<select class="form-control input-sm col-md-6" id="email">
		<option value=""> {{ trans('forms.select_option') }}</option>

		@foreach ($emails as $email)
			<option value="{{ $email->id }}"> {{ $email->email }}</option>
		@endforeach
	</select>

	<div class="ml-2">
		<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editEmail" onclick="return editEmail()">
			<span class="fas fa-edit"></span> 
		</button>

		<button type="button" class="btn btn-info btn-md" onclick="return destroyEmail()">
			<span class="fas fa-trash"></span> 
		</button>
	</div>
</div>