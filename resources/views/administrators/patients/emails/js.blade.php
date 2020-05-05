<script type="text/javascript">
	function editEmail() {
		var parameters = {
			"id" : $("#email").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/emails/edit') }}",
			type:  'post',
			dataType: 'json',
			beforeSend: function () {
				$("#modal_email_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }} ');
			},
			success:  function (data) {
				$("#modal_email_messages").html("");

				// Load results
				$("#modal_email_id").val(data['id']);
				$("#modal_email_email").val(data['email']);
			}
		});

		return false;   	
	}

	function updateEmail() {
		var parameters = {
			"id" : $("#modal_email_id").val(),
			"email" : $("#modal_email_email").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/emails/update') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_email_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
				$("#modal_email_messages").html('<div class="alert alert-success fade show"> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("emails.success_edited_email") }} </div>');
			}
		});

		return false;   	
	}

</script>