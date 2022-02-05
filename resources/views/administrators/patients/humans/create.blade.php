@extends('administrators/patients/create')

@section('js')
@parent

<script type="text/javascript">
    $(function () 
    {
        $("#socialWorkAutoComplete").autocomplete({
            minLength: 2,
            source: function (event, ui) {
                var parameters = {
                    "filter": $("#socialWorkAutoComplete").val()
                };

                $.ajax({
                    data: parameters,
                    url: '{{ route("administrators/settings/social_works/getSocialWorks") }}',
                    type: 'post',
                    dataType: 'json',
                    success: ui
                });

                return ui;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#plan').val(ui.item.plan_id);
                $('#socialWorkAutoComplete').val(ui.item.label);
                
            }
        });
    });
</script>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/patients/store') }}">
    @csrf

    <input type="hidden" name="type" value="human">

    <div class="col-10 mt-3">  
        <h4><i class="fas fa-id-card"></i> {{ trans('patients.personal_data') }} </h4>
		<hr class="col-6">

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.full_name') }} </span>
            </div>
            
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.identification_number') }} </span>
            </div>
            
            <input type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ old('identification_number') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.home_address') }} </span>
            </div>
            
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.city') }} </span>
            </div>
            
            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.sex') }} </span>
            </div>

            <select class="form-select @error('sex') is-invalid @enderror" name="sex" id="sex" required>
                <option value=""> {{ trans('forms.select_option') }} </option>
                <option value="F"> {{ trans('patients.female') }} </option>
                <option value="M"> {{ trans('patients.male') }} </option>
            </select>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
            </div>

            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}">
        </div>   

		<div class="mt-3">
			<h4><i class="fas fa-phone"></i> {{ trans('forms.contact_information') }} </h4>
			<hr class="col-6">

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.phone') }} </span>
				</div>
				<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ @old('phone') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_phone') }} </span>
				</div>
				<input type="text" class="form-control @error('alternative_phone') is-invalid @enderror" name="alternative_phone" value="{{ @old('alternative_phone') }}">
			</div>

			<div class="input-group mt-2">
				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.email') }} </span>
				</div>
				<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ @old('email') }}">

				<div class="input-group-prepend">
					<span class="input-group-text"> {{ trans('patients.alternative_email') }} </span>
				</div>
				<input type="email" class="form-control @error('alternative_email') is-invalid @enderror" name="alternative_email" value="{{ @old('alternative_email') }}">
			</div>
		</div>

        <div class="mt-3">
            <h4><i class="fas fa-heart"></i> {{ trans('social_works.social_work') }} </h4>
			<hr class="col-6">

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
                </div>

                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') }}">
                <input type="hidden" name="plan_id" id="plan" value="{{ @old('plan_id') }}">
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.affiliate_number') }} </span>
                </div>

                <input type="text" class="form-control @error('affiliate_number') is-invalid @enderror" name="affiliate_number" value="{{ old('affiliate_number') }}">
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.security_code') }} </span>
                </div>

                <input type="number" class="form-control @error('security_code') is-invalid @enderror" name="security_code" min="100" max="999" value="{{ old('security_code') }}">
            </div>

            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('social_works.expiration_date') }} </span>
                </div>

                <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}">
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection