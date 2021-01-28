@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

        $(function () {
            $("#billing_period").autocomplete({
                minLength: 2,
                source: function (event, ui) {
                    var parameters = {
                        "filter": $("#billing_period").val()
                    };

                    $.ajax({
                        data: parameters,
                        url: '{{ route("administrators/settings/social_works/billing_periods/load_billing_periods") }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {
                            //$("#resultados").html('<div class="spinner-border text-info"> </div> Procesando, espere por favor...');
                        },
                        success: ui
                    });

                    return ui;
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $('#billing_period').val(ui.item.label);
                    $('#billing_period_id').val(ui.item.id);
                }
            });
        });
    </script>
@endsection

@section('title')
    {{ trans('payment_social_works.edit_payment') }}
@endsection

@section('content-title')
    <i class="fas fa-plus"> </i> {{ trans('payment_social_works.edit_payment') }}
@endsection


@section('content')

    <div class="input-group mt-2 mb-1 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
        </div>

        <input type="text" class="form-control" value="{{ $payment->social_work->name }}" readonly>
    </div>

    <form method="post" action="{{ route('administrators/settings/social_works/payments/update', ['id' => $payment->id]) }}">
        @csrf
        @method('PUT')

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('payment_social_works.payment_date') }} </span>
            </div>

            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date') ?? $payment->payment_date }}" required>

            @error('payment_date')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('billing_periods.billing_period') }} </span>
            </div>

            <input id ="billing_period" type="text" name="billing_period" class="form-control @error('billing_period_id') is-invalid @enderror" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('billing_period') ?? $payment->billing_period->name }}" required>
            <input id="billing_period_id" type="hidden" name="billing_period_id" value="{{ old('billing_period_id') ?? $payment->billing_period->id }}">
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('payment_social_works.amount') }} </span>
            </div>

            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $payment->amount }}" required>

            @error('amount')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <input id="submit-button" type="submit" style="display: none;">
    </form>
@endsection

@section('more-content')
    <div class="card-footer">
        <div class="float-right">
            <button type="submit" class="btn btn-primary" onclick="send();">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </div>
@endsection
