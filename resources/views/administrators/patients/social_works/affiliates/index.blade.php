<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-heartbeat"></i> {{ trans('social_works.social_works') }} </h4>
	</div>

	<div class="card-body">
		<div id="affiliates_messages">
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
			</div>

			<select class="form-select input-sm col-md-6" id="affiliate">
				<option value=""> {{ trans('forms.select_option') }}</option>
				@foreach ($patient->affiliates as $affiliate)
					<option value="{{ $affiliate->id }}">
						@if (!empty($affiliate->expiration_date) && $affiliate->expiration_date < date("Y-m-d"))
							** {{ trans('social_works.expired_card') }} **
						@endif

						{{ $affiliate->plan->social_work->name }} {{ $affiliate->plan->name }}

						@if (!empty($affiliate->affiliate_number))
							[{{ $affiliate->affiliate_number }}]
						@endif
					</option>
				@endforeach
			</select>

			<div class="ms-2">
				<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editAffiliate" onclick="return editAffiliate()">
					<span class="fas fa-edit"></span>
				</button>

				<button type="button" class="btn btn-info btn-md" onclick="return destroyAffiliate()">
					<span class="fas fa-trash"></span>
				</button>
			</div>
		</div>
	</div>
</div>
