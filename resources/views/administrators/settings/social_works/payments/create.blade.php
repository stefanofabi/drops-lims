@extends('administrators/settings/index')

@section('title')
{{ trans('payment_social_works.create_payment') }}
@endsection

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
				<a class="nav-link" href="{{ route('administrators/settings/social_works/payments/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-plus"> </i> {{ trans('payment_social_works.create_payment') }}
@endsection

@section('content')
    <div class="input-group mt-3 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
        </div>

        <input type="text" class="form-control" value="{{ $social_work->name }}" readonly>
    </div>

    <form method="post" action="{{ route('administrators/settings/social_works/payments/store') }}">
        @csrf

        <input type="hidden" name="social_work_id" value="{{ $social_work->id }}">

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('payment_social_works.payment_date') }} </span>
            </div>

            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date') ?? date('Y-m-d') }}" required>

            @error('payment_date')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('billing_periods.billing_period') }} </span>
            </div>

            <input id ="billing_period" type="text" name="billing_period" class="form-control @error('billing_period_id') is-invalid @enderror" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('billing_period') }}" required>
            <input id="billing_period_id" type="hidden" name="billing_period_id" value="{{ old('billing_period_id') }}">
        </div>

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('payment_social_works.amount') }} </span>
            </div>

            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? '0.00' }}" min="0" required>

            @error('amount')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
    </form>
@endsection