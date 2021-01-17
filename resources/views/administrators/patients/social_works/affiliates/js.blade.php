<script type="text/javascript">

	var plan;
	var change = false;

	function editAffiliate() {
        // In case the user had already opened the modal
	    change = false;

		var affiliate = $("#affiliate").val();

		if (!affiliate) {
			alert('{{ trans('forms.select_option') }}');
			return false;
		}

		var parameters = {
			"id" : affiliate,
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/social_works/affiliates/edit') }}",
			type:  'post',
			dataType: 'json',
			beforeSend: function () {
				$("#modal_affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }} ');
			},
			success:  function (data) {

				// Load results
				$("#modal_affiliates_id").val(data['id']);
				$("#modal_affiliates_social_work").val(data['social_work_id']);
				$("#modal_affiliates_affiliate_number").val(data['affiliate_number']);
				$("#modal_affiliates_security_code").val(data['security_code']);
				$("#modal_affiliates_expiration_date").val(data['expiration_date']);
				plan = data['plan_id'];

				load_plans();

			}
		});

    	return false;
	}

	function updateAffiliate() {
		var parameters = {
			"id" : $("#modal_affiliates_id").val(),
			"plan_id" : $("#modal_affiliates_plan").val(),
			"affiliate_number" : $("#modal_affiliates_affiliate_number").val(),
			"security_code" : $("#modal_affiliates_security_code").val(),
			"expiration_date" : $("#modal_affiliates_expiration_date").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/social_works/affiliates/update') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
				$("#modal_affiliates_messages").html('<div class="alert alert-success fade show"> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans_choice("social_works.success_edited_affiliate", $patient->sex) }} </div>');
			}
		});

		return false;
	}

	function load_plans() {

		var parameters = {
			"social_work_id" : $("#modal_affiliates_social_work").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/settings/social_works/plans/load') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {

						$("#modal_affiliates_plan").empty();
						var select_plan = new Option('{{ trans('forms.select_option') }}', '');
						$("#modal_affiliates_plan").append(select_plan);

						$(jQuery.parseJSON(JSON.stringify(response))).each(function() {
						         var option = new Option(this.name, this.id);

								/// jquerify the DOM object 'o' so we can use the html method
								$(option).html(this.name);
								$("#modal_affiliates_plan").append(option);
						});

						// fix visual bug
						if (!change) {
							$("#modal_affiliates_plan").val(plan);
							change = true;
						}
					}
				}).fail( function() {
                    $("#modal_affiliates_messages").html('<div class="alert alert-danger fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("errors.not_found") }} </div>');
                }).done( function() {
					$("#modal_affiliates_messages").html("");
				});

		return false;
	}

	function destroyAffiliate() {
		var affiliate = $("#affiliate").val();

		if (!affiliate) {
			alert('{{ trans('forms.select_option') }}');
			return false;
		}

		var parameters = {
			"id" : affiliate,
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/social_works/affiliates/destroy') }}",
			type:  'post',
			beforeSend: function () {
				$("#affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {

				$('#affiliate option[value="'+affiliate+'"]').remove();

				$("#affiliates_messages").html('<div class="alert alert-success fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("social_works.success_destroy_affiliate") }} </div>');
			}
		}).fail( function() {
    		$("#affiliates_messages").html('<div class="alert alert-warning fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.warning") }}! </strong> {{ trans("social_works.warning_destroy_affiliate") }} </div>');
		});


		return false;
	}

</script>
