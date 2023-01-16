@extends('administrators/settings/index')

@section('js')
<script type="module">
    const autoCompleteJS = new autoComplete({
        selector: "#billing_period",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/billing_periods/load_billing_periods") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#billing_period").val() }),
                        headers: { 
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "Content-Type" : "application/json",
                        }
                    });
                    
                    // Data should be an array of `Objects` or `Strings`
                    const data = await source.json();

                return data;
                } catch (error) {
                    return error;
                }
            },
            // Data source 'Object' key to be searched
            keys: ["name"],
            cache: false,
        },
        searchEngine: function (q, r) { return r; },
        events: {
            input: {
                focus() {
                    autoCompleteJS.start();
                },
            },
        },
        resultItem: {
            element: (item, data) => {
                // Modify Results Item Style
                item.style = "display: flex; justify-content: space-between;";
                // Modify Results Item Content
                item.innerHTML = `
                <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                ${data.match}
                </span>
                <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
                [${data.value.start_date}, ${data.value.end_date}]
                </span>`;
            },
            highlight: 25
        },
        threshold: 2,
        resultsList: {
            element: (list, data) => {
                if (data.results.length > 0) {
                    const info = document.createElement("div");
                    info.setAttribute("class", "centerAutoComplete");
                    info.innerHTML = `Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results`;
                    list.prepend(info);
                } else {
                    // Create "No Results" message list element
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    // Add message text content
                    message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                    // Add message list element to the list
                    list.appendChild(message);
                }
            },
            noResults: true,
            maxResults: undefined,
        },
    });

    autoCompleteJS.input.addEventListener("selection", function (event) {
        const feedback = event.detail;
        autoCompleteJS.input.blur();

        const selected = feedback.selection.value;

        $('#billing_period_id').val(selected.id);
    
        autoCompleteJS.input.value = selected.name;
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
<form method="post" action="{{ route('administrators/settings/social_works/payments/update', ['id' => $payment->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="social_work_id" value="{{ $payment->social_work_id}}">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="socialWork"> {{ trans('social_works.social_work') }} </label>
                <input type="text" class="form-control" value="{{ $payment->social_work->name }}" id="socialWork" aria-describedby="socialWorkHelp" disabled>
                                
                <small id="socialWorkHelp" class="form-text text-muted"> The social work to which the payment will be charged </small>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group mt-4">
                <input id ="billing_period" type="text" name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('billing_period') ?? $payment->billing_period->name }}" aria-describedby="billingPeriodHelp" required>
                <input id="billing_period_id" type="hidden" name="billing_period_id" value="{{ old('billing_period_id') ?? $payment->billing_period->id }}">

                <div>
                    <small id="billingPeriodHelp" class="form-text text-muted"> The period to which the payment made by the social work corresponds </small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="payment_date"> {{ trans('payment_social_works.payment_date') }} </label>
                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" id="payment_date" value="{{ old('payment_date') ?? $payment->payment_date }}" aria-describedby="paymentDateHelp" required>
            
                <small id="paymentDateHelp" class="form-text text-muted"> The payment date on which the social work made the payment </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="amount"> {{ trans('payment_social_works.amount') }} </label>
                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') ?? $payment->amount }}" min="0" aria-describedby="amountHelp" required>

                <small id="amountHelp" class="form-text text-muted"> The amount of payment received for the social work. It can be different from the total billed in the period </small>
            </div>
        </div>
    </div>
    
    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>

@endsection