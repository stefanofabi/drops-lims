@section('js')
    <script type="text/javascript">
        function setBanExpiration(minutes) {

            // Ban permanently
            if (minutes == "") {
                $("#expired_at").val(''); 
                return;  
            }

            var dateVal = new Date();
            
            dateVal.setMinutes(dateVal.getMinutes() + parseInt(minutes, 10));

            var day = dateVal.getDate().toString().padStart(2, "0");
            var month = (1 + dateVal.getMonth()).toString().padStart(2, "0");
            var hour = dateVal.getHours().toString().padStart(2, "0");
            var minute = dateVal.getMinutes().toString().padStart(2, "0");
            //var sec = dateVal.getSeconds().toString().padStart(2, "0");
            //var ms = dateVal.getMilliseconds().toString().padStart(3, "0");

            var inputDate = dateVal.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute);        //  + ":" + (sec) + "." + (ms)
            
            $("#expired_at").val(inputDate);   
        }

        function storeBan() {
		var parameters = {
            "_token" : '{{ csrf_token() }}',
			"id" : $("#id").val(),
			"expired_at" : $("#expired_at").val(),
            "comment" : $("#comment").val()
		};
        
		$.ajax({
			data:  parameters,
			url:   "{{ route('administrators/settings/bans/store') }}",
			type:  'post',
			beforeSend: function () {
				$("#modal_bans_messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
			},
			success:  function (response) {
				$("#modal_bans_messages").html('<div class="alert alert-success fade show"> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("bans.user_banned_successfully") }} </div>');              
			}
		}).fail( function(response) {
    		$("#modal_bans_messages").html('<div class="alert alert-danger alert-dismissible fade show"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <strong> {{ trans("forms.danger") }}! </strong> '+response.responseJSON['message']+' </div>');
		});

		return false;   	
	}

    function sendBanForm() {
        $('#submitBan').click();
    }
    </script>
@append

<!-- Modal Ban User -->
<div class="modal fade" id="banUserModal" tabindex="-1" aria-labelledby="banUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="banUserModalLabel"> {{ trans('bans.ban_user') }} </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="modal_bans_messages"> </div>

        <form method="POST" onsubmit="return storeBan();">
            @csrf 

            <input type="hidden" name="id" id="id" value="{{ $user->id }}">

            <div class="row mt-3">
                <label for="full_name" class="col-md-2 col-form-label"> {{ trans('users.full_name') }} </label>
                
                <div class="col-md-10">
                  <input type="text" class="form-control" id="full_name" value="{{ $user->full_name }}" readonly>
                </div>
            </div>

            <div class="row mt-3">
              <label for="email" class="col-md-2 col-form-label"> {{ trans('users.email') }} </label>

              <div class="col-md-10">
                <input type="email" class="form-control" id="email" value="{{ $user->email}}" readonly>
              </div>
            </div>

            <div class="row mt-3">
                <label for="comment" class="col-sm-2 col-form-label"> {{ trans('bans.comment') }} </label>
                
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="comment" name="comment" required>
                </div>
            </div>

            <div class="row mt-3">
                <label for="expired_at" class="col-md-2 col-form-label"> {{ trans('bans.expired_at') }} </label>
                
                <div class="col-md-10">
                  <input type="datetime-local" class="form-control" id="expired_at" name="expired_at">

                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-3" onclick="setBanExpiration('5')"> {{ trans('bans.5_minutes') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-3" onclick="setBanExpiration('15')"> {{ trans('bans.15_minutes') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-3" onclick="setBanExpiration('30')"> {{ trans('bans.30_minutes') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-3" onclick="setBanExpiration('60')"> {{ trans('bans.60_minutes') }}</button>
                  
                  <br />
                  
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-2" onclick="setBanExpiration('1440')"> {{ trans('bans.1_day') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-2" onclick="setBanExpiration('4320')"> {{ trans('bans.3_days') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-2" onclick="setBanExpiration('7200')"> {{ trans('bans.5_days') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-2" onclick="setBanExpiration('43200')"> {{ trans('bans.30_days') }}</button>
                  <button type="button" class="btn btn-primary btn-sm ml-1 mt-2" onclick="setBanExpiration('')"> {{ trans('bans.permanently') }}</button>
                </div>
            </div>

            <input type="submit" class="d-none" id="submitBan"></input>
          </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="return sendBanForm();"> {{ trans('bans.ban_user') }}</button>
      </div>
    </div>
  </div>
</div>