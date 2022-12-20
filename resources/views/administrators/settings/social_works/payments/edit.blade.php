@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
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

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/payments/index', ['social_work_id' => $payment->social_work_id]) }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('title')
{{ trans('payment_social_works.edit_payment') }}
@endsection

@section('content-title')
<i class="fas fa-plus"></i> {{ trans('payment_social_works.edit_payment') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Leave records of the payments made by a social work to be able to keep a historical control
</p>
@endsection

@section('content')
<div class="col-md-6">
    <div class="form-group mt-2">
        <label for="socialWork"> {{ trans('social_works.social_work') }} </label>
        <input type="text" class="form-control" value="{{ $payment->social_work->name }}" id="socialWork" aria-describedby="socialWorkHelp" disabled>
                        
        <small id="socialWorkHelp" class="form-text text-muted"> The social work to which the payment will be charged </small>
    </div>

    <form method="post" action="{{ route('administrators/settings/social_works/payments/update', ['id' => $payment->id]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="social_work_id" value="{{ $payment->social_work_id}}">

        <div class="form-group mt-2">
            <label for="payment_date"> {{ trans('payment_social_works.payment_date') }} </label>
            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" id="payment_date" value="{{ old('payment_date') ?? $payment->payment_date }}" aria-describedby="paymentDateHelp" required>
        
            <small id="paymentDateHelp" class="form-text text-muted"> The payment date on which the social work made the payment </small>
        </div>

        <div class="form-group mt-2">
            <label for="billing_period"> {{ trans('billing_periods.billing_period') }} </label>
            <input id ="billing_period" type="text" name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('billing_period') ?? $payment->billing_period->name }}" aria-describedby="billingPeriodHelp" required>
            <input id="billing_period_id" type="hidden" name="billing_period_id" value="{{ old('billing_period_id') ?? $payment->billing_period->id }}">

            <small id="billingPeriodHelp" class="form-text text-muted"> The period to which the payment made by the social work corresponds </small>
        </div>

        <div class="form-group mt-2">
            <label for="amount"> {{ trans('payment_social_works.amount') }} </label>
            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') ?? $payment->amount }}" min="0" aria-describedby="amountHelp" required>

            <small id="amountHelp" class="form-text text-muted"> The amount of payment received for the social work. It can be different from the total billed in the period </small>
        </div>

        <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
    </form>
</div>
@endsection