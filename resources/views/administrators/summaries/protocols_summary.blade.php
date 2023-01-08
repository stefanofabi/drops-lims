<div class="card mt-3">
    <div class="card-header"><h5> {{ trans('summaries.protocols_summary') }} </h5></div>

    <div class="card-body">
        {{ trans('summaries.protocols_summary_message') }}

        <form method="post" target="_blank" action="{{ route('administrators/summaries/protocols_summary') }}">
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

            <input id="generate_protocols_report" type="submit" style="display: none;">
        </form>
    </div>

    <div class="card-footer">
        <div class="text-right">
            <button onclick="send('generate_protocols_report');" class="btn btn-primary">
                <span class="fas fa-file-pdf"></span> {{ trans('summaries.generate_summary') }}
            </button>
        </div>
    </div>
</div>
