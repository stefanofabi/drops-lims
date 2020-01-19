<!-- Modal -->
<div class="modal fade" id="editPhone">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="fas fa-phone"></i> {{ trans('phones.edit_phone') }} </h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<!-- Carga los datos ajax -->
				<div id="modal_phones_messages"></div>
				
				<form class="form-horizontal" method="post" onsubmit="return updatePhone();">

					<input type="hidden" id="modal_phone_id" name="id">

					<div class="form-group">
						<div class="input-group mb-4 col-md-9 input-form">
							<div class="input-group-prepend">
								<span class="input-group-text"> {{ trans('patients.phone') }} </span>
							</div>

							<input type="text" class="form-control" id="modal_phone_phone" name="phone" required>
						</div>

					</div>

					<div class="input-group mb-4 col-md-9 input-form">
						<div class="input-group-prepend">
							<span class="input-group-text"> {{ trans('patients.type') }} </span>
						</div>

						<select class="form-control input-sm" id="modal_phone_type" name="type">
							<option value=""> {{ trans('patients.select_type') }} </option>
							<option value="{{ trans('patients.landline') }}"> {{ trans('patients.landline') }} </option>
							<option value="{{ trans('patients.mobile') }}"> {{ trans('patients.mobile') }} </option>
							<option value="{{ trans('patients.whatsapp') }}"> {{ trans('patients.whatsapp') }} </option>
						</select>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> {{ trans('forms.save') }} </button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"> {{ trans('forms.cancel') }} </button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>