<script type="text/javascript">
	function editPhone() {
		var parameters = {
			"id" : $("#phone").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('patients/phones/edit') }}",
			type:  'post',
			dataType: 'json',
			beforeSend: function () {
				$("#modal_phones_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }} ');
			},
			success:  function (data) {
				$("#modal_phones_messages").html("");

				// Load results
				$("#modal_phone_id").val(data['id']);
				$("#modal_phone_phone").val(data['phone']);
				$("#modal_phone_type option[value='"+data['type']+"']").attr("selected",true);
			}
		});

		return false;   	
	}

	function updatePhone() {
		var parameters = {
			"id" : $("#modal_phone_id").val(),
			"phone" : $("#modal_phone_phone").val(),
			"type" : $("#modal_phone_type").val(),
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('patients/phones/update') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_phone_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
				$("#modal_phone_messages").html('<div class="alert alert-success fade show"> {{ trans("emails.success_edited_phone") }} </div>');
			}
		});

		return false;   	
	}

</script>