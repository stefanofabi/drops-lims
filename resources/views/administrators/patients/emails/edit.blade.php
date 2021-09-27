<!-- Modal Email -->
<div class="modal fade" id="editEmail" tabindex="-1" aria-labelledby="editModalEmail" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-at"></i> {{ trans('emails.edit_email') }} </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<!-- Ajax results -->
				<div id="modal_email_messages"> </div>

				<form class="form-horizontal" method="post" onsubmit="return updateEmail()">
					<input type="hidden" id="modal_email_id" name="id">

					<div class="form-group">
						<label for="estado" class="col-sm-3 control-label"> <b> {{ trans('emails.email') }} </b> </label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="modal_email_email" name="email" required>
						</div>
					</div>

					
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> {{ trans('forms.save') }} </button>
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal"> {{ trans('forms.cancel') }} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>