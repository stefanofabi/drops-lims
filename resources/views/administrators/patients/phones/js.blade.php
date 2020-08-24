<script type="text/javascript">
	function editPhone() {
		var phone = $("#phone").val();

		if (!phone) {
			alert('{{ trans('forms.select_option') }}');
			return false;
		}

		var parameters = {
			"id" : phone,
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/phones/edit') }}",
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
			url:   "{{ route('administrators/patients/phones/update') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_phones_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
				$("#modal_phones_messages").html('<div class="alert alert-success fade show"> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("phones.success_edited_phone") }} </div>');
			}
		});

		return false;   	
	}

	function destroyPhone() {
		var phone = $("#phone").val();

		if (!phone) {
			alert('{{ trans('forms.select_option') }}');
			return false;
		}

		var parameters = {
			"id" : phone,
		};

		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/patients/phones/destroy') }}",
			type:  'post',
			beforeSend: function () {
				$("#phones_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {

				$('#phone option[value="'+phone+'"]').remove();

				$("#phones_messages").html('<div class="alert alert-success fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("phones.success_destroy_phone") }} </div>');
			}
		}).fail( function() {
    		$("#phones_messages").html('<div class="alert alert-warning fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button> <strong> {{ trans("forms.warning") }}! </strong> {{ trans("phones.warning_destroy_phone") }} </div>');
		});


		return false;
	}
</script>