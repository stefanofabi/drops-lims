		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('emails.emails') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" readonly>
				<option value=""> {{ trans('forms.select_option') }}</option>

				@foreach ($patient->emails as $email)
				<option value=""> {{ $email->email }}</option>
				@endforeach
			</select>
		</div>
