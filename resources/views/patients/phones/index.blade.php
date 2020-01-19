			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phones') }} </span>
				</div>

				<select class="form-control input-sm col-md-6" id="phone" style="margin-right: 1%">
					<option value=""> {{ trans('patients.select_phone') }}</option>

					@foreach ($phones as $phone)
					<option value="{{ $phone->id }}"> {{ $phone->phone }}</option>
					@endforeach
				</select>

				<div>
					<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editPhone" onclick="return editPhone()">
						<span class="fas fa-edit"></span> 
					</button>

					<button type="button" class="btn btn-info btn-md" onclick="return eliminarTelefonoBaul()">
						<span class="fas fa-trash"></span> 
					</button>
				</div>
			</div>