<div class="card">
    <div class="card-header"><h5> {{ trans('settings.protocols_report') }} </h5></div>

    <div class="card-body">
        <form method="post" target="_blank" action="{{ route('administrators/settings/protocols_report') }}">
            @csrf

            <div class="input-group col-md-6 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('statistics.initial_date') }} </span>
                </div>

                <input type="date" class="form-control" name="initial_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="input-group mt-2 col-md-6 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('statistics.ended_date') }} </span>
                </div>

                <input type="date" class="form-control" name="ended_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <input id="generate_protocols_report" type="submit" style="display: none;">
        </form>
    </div>

    <div class="card-footer">
        <div class="text-right">
            <button onclick="send('generate_protocols_report');" class="btn btn-primary">
                <span class="fas fa-file-pdf"></span> {{ trans('settings.generate_report') }}
            </button>
        </div>
    </div>
</div>
