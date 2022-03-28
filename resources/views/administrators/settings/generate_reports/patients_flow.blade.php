<div class="card mt-3">
    <div class="card-header"><h5> {{ trans('settings.patients_flow') }} </h5></div>

    <div class="card-body">
        {{ trans('settings.patient_flow_message') }}

        <form method="post" target="_blank" action="{{ route('administrators/settings/patients_flow') }}">
            @csrf

            <div class="input-group col-md-6 input-form mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('statistics.initial_date') }} </span>
                </div>

                <input type="date" class="form-control" name="initial_date" value="{{ date('Y-m-d', strtotime('now - 1 month')) }}" required>
            </div>

            <div class="input-group mt-2 col-md-6 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('statistics.ended_date') }} </span>
                </div>

                <input type="date" class="form-control" name="ended_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <input id="submit_patients_flow" type="submit" style="display: none;">
        </form>
    </div>

    <div class="card-footer">
        <div class="text-right">
            <button onclick="send('submit_patients_flow');" class="btn btn-primary">
                <span class="fas fa-file-pdf"></span> {{ trans('settings.generate_report') }}
            </button>
        </div>
    </div>
</div>
