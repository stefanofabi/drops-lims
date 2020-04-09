<div class="card mt-3">
	<div class="card-header">
		<h4><i class="fas fa-heartbeat"></i> {{ trans('social_works.social_works') }} </h4>
	</div>

	<div class="card-body">
		<div class="input-group mb-3">
			<div class="input-group-prepend mb-3">
				<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
			</div>

			<select class="form-control input-sm col-md-6" readonly>
				<option value=""> {{ trans('social_works.select_social_work') }}</option>
				@foreach ($affiliates as $affiliate)
				<option value=""> 
					@if (!empty($affiliate->expiration_date) && $affiliate->expiration_date < date("Y-m-d"))
					** {{ trans('social_works.expired_card') }} **
					@endif

					{{ $affiliate->social_work }} {{ $affiliate->plan }} 
					
					@if (!empty($affiliate->affiliate_number))
						[{{ $affiliate->affiliate_number }}]
					@endif
				</option>
				@endforeach
			</select>
		</div>
	</div>
</div>