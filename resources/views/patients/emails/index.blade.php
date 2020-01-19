			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.emails') }} </span>
				</div>

				<select class="form-control input-sm col-md-6" id="email" style="margin-right: 1%">
					<option value=""> {{ trans('patients.select_email') }}</option>

					@foreach ($emails as $email)
					<option value="{{ $email->id }}"> {{ $email->email }}</option>
					@endforeach
				</select>

				<div>
					<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editEmail" onclick="return editEmail()">
						<span class="fas fa-edit"></span> 
					</button>

					<button type="button" class="btn btn-info btn-md" onclick="return destroyEmail()">
						<span class="fas fa-trash"></span> 
					</button>
				</div>
			</div>