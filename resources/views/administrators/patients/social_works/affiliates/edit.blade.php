<!-- Modal -->
<div class="modal fade" id="editAffiliate" tabindex="-1" aria-labelledby="editModalAffiliate" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="fas fa-address-card"></i> {{ trans('social_works.edit_affiliate') }}</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">

				<!-- Carga los datos ajax -->
				<div id="modal_affiliates_messages"> </div>


				<form class="form-horizontal" method="post" onsubmit="return updateAffiliate();">

					<input type="hidden" id="modal_affiliates_id">

					<div class="form-group">
						<label for="obra-social" class="col-sm-6 control-label"><b> {{ trans('social_works.social_work') }}: </b> </label>
						<div class="col-sm-8">
							<select class="form-control input-sm" id="modal_affiliates_social_work" onchange="load_plans()" required>
								<option value=""> {{ trans('forms.select_option') }} </option>
								@foreach ($social_works as $social_work)
								<option value="{{ $social_work->id }}"> {{ $social_work->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Load ajax for plans -->
					<div class="form-group">
						<label for="obra-social" class="col-sm-6 control-label"><b> {{ trans('social_works.plan') }}: </b> </label>
						<div class="col-sm-8">
								<select class="form-control input-sm" id="modal_affiliates_plan" required>
									<option value=""> {{ trans('forms.select_option') }} </option>
								</select>
						</div>
					</div>	

					<div class="form-group">
						<label for="estado" class="col-sm-8 control-label"> <b> {{ trans('social_works.affiliate_number') }}:</b>  </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="modal_affiliates_affiliate_number">
						</div>
					</div>

					<div class="form-group">
						<label for="estado" class="col-sm-8 control-label"><b> {{ trans('social_works.security_code') }}:</b>  </label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="modal_affiliates_security_code">
						</div>
					</div>

					<div class="form-group">
						<label for="estado" class="col-sm-8 control-label"><b> {{ trans('social_works.expiration_date') }}: </b> </label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="modal_affiliates_expiration_date">
						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> {{ trans('forms.save') }} </button>
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal"> {{ trans('forms.cancel') }} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
