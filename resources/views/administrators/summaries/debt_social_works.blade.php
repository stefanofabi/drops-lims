<div class="card mt-3">
    <div class="card-header"><h5> {{ trans('summaries.debt_social_works') }} </h5></div>

    <div class="card-body">
        {{ trans('summaries.debt_social_works_message') }}

        <form method="post" target="_blank" action="{{ route('administrators/summaries/debt_social_works') }}">
            @csrf

            <div class="input-group col-md-6 input-form mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.start_date') }} </span>
                </div>

                <input type="date" class="form-control" name="start_date" value="{{ date('Y-m-d', strtotime('now - 1 month')) }}" required>
            </div>

            <div class="input-group mt-2 col-md-6 input-form">
                <div class="input-group-prepend">
                    <span class="input-group-text"> {{ trans('billing_periods.end_date') }} </span>
                </div>

                <input type="date" class="form-control" name="end_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <input id="submit_debt_social_works" type="submit" style="display: none;">
        </form>
    </div>

    <div class="card-footer">
        <div class="text-right">
            <button onclick="send('submit_debt_social_works');" class="btn btn-primary">
                <span class="fas fa-file-pdf"></span> {{ trans('summaries.generate_summary') }}
            </button>
        </div>
    </div>
</div>
