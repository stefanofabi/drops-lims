		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('patients.emails') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" style="margin-right: 1%" readonly>
				<option value=""> {{ trans('patients.select_email') }}</option>

				@foreach ($emails as $email)
				<option value=""> {{ $email->email }}</option>
				@endforeach
			</select>
		</div>