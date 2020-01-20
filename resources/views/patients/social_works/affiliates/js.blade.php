<script type="text/javascript">

	var plan;
	var change = false;

	function editAffiliate() {
		var parameters = {
			"id" : $("#affiliate").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('patients/social_works/affiliates/edit') }}",
			type:  'post',
			dataType: 'json',
			beforeSend: function () {
				$("#modal_affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }} ');
			},
			success:  function (data) {
				$("#modal_affiliates_messages").html("");

				// Load results
				$("#modal_affiliates_id").val(data['id']);
				$("#modal_affiliates_social_work").val(data['social_work_id']);
				$("#modal_affiliates_affiliate_number").val(data['affiliate_number']);
				$("#modal_affiliates_security_code").val(data['security_code']);
				$("#modal_affiliates_expiration_date").val(data['expiration_date']);
				plan = data['plan_id'];
			}
		}).done (function() {
			load_plans();
		});

    return false;   	
}

function updateAffiliate() {
	var parameters = {
		"id" : $("#modal_affiliates_id").val(),
		"social_work_id" : $("#modal_affiliates_social_work").val(),
		"plan_id" : $("#plan").val(),
		"affiliate_number" : $("#modal_affiliates_affiliate_number").val(),
		"security_code" : $("#modal_affiliates_security_code").val(),
		"expiration_date" : $("#modal_affiliates_expiration_date").val(),
	};

	$.ajax({
		data:  parameters,
		url:   "{{ route('patients/social_works/affiliates/update') }}",
		type:  'post',
		beforeSend: function () {
			$("#modal_affiliates_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
		},
		success:  function (response) {
			$("#modal_affiliates_messages").html('<div class="alert alert-success fade show"> {{ trans("social_works.success_edited_affiliate") }} </div>');
		}
	});

	return false;   	
}

</script>


<script type="text/javascript">
	function load_plans() {
		var parameters = {
			"social_work" : $("#modal_affiliates_social_work").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('patients/social_works/plans/load_plans') }}",
			type:  'post',
			beforeSend: function () {
				$("#plans").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
						// Load data
						$("#plans").html(response);
						if (!change) {
							// With this conditional we fix a visual bug by selecting an option that does not exist
							$("#plan").val(plan);
							change = true;
						}
					}
				});

		return false;
	}
</script>