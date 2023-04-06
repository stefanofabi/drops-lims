@extends('administrators/default-template')

@section('title')
{{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="module">
    const prescriberAutoComplete = new autoComplete({
        selector: "#prescriberAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/prescribers/load_prescribers") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#prescriberAutoComplete").val() }),
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
            keys: ["full_name"],
            cache: false,
        },
        searchEngine: function (q, r) { return r; },
        events: {
            input: {
                focus() {
                    prescriberAutoComplete.start();
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
                PE-${data.value.primary_enrollment} SE-${data.value.secondary_enrollment}
                </span>`;
            },
            highlight: true
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
            maxResults: 25,
        },
    });

    prescriberAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        prescriberAutoComplete.input.blur();

        const selected = feedback.selection.value;
        
        $('#prescriber').val(selected.id);
        
        prescriberAutoComplete.input.value = selected.full_name;
    });

    const socialWorkAutoComplete = new autoComplete({
        selector: "#socialWorkAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/social_works/getSocialWorks") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#socialWorkAutoComplete").val() }),
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
            keys: ["social_work"],
            cache: false,
        },
        searchEngine: function (q, r) { return r; },
        events: {
            input: {
                focus() {
                    socialWorkAutoComplete.start();
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
                ${data.value.plan}
                </span>`;
            },
            highlight: true
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
            maxResults: 25,
        },
    });

    socialWorkAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        socialWorkAutoComplete.input.blur();

        const selected = feedback.selection.value;

        $('#planAutoComplete').val(selected.plan);
        $('#plan').val(selected.plan_id);
        
        socialWorkAutoComplete.input.value = selected.social_work;
    }); 

    const billingPeriodAutoComplete = new autoComplete({
        selector: "#billingPeriodAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/billing_periods/load_billing_periods") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#billingPeriodAutoComplete").val() }),
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
                    billingPeriodAutoComplete.start();
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
                [${data.value.start_date} - ${data.value.end_date}]
                </span>`;
            },
            highlight: true
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
            maxResults: 25,
        },
    });

    billingPeriodAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        billingPeriodAutoComplete.input.blur();

        const selected = feedback.selection.value;

        $('#billing_period_id').val(selected.id);
    
        billingPeriodAutoComplete.input.value = selected.name;
    });
</script>


<script type="text/javascript">
    function enableSubmitForm() 
    {
        $('#securityMessage').hide('slow');

        $("input").removeAttr('disabled');
        $("select").removeAttr('disabled');
        $("textarea").removeAttr('disabled');

        $("#patientAutoComplete").attr('disabled', true);
        $("#planAutoComplete").attr('disabled', true);
        
    }
    
    function closeProtocol()
    {
        if (confirm("{{ trans('forms.confirm') }}")) 
        {
            $('#close_protocol').submit();
        }

        return false;
    }

    function sendEmailProtocol() 
    {
        $('#send_email_protocol').submit();
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link @cannot('manage practices') disabled @endcannot" href="{{ route('administrators/protocols/practices/index', ['internal_protocol_id' => $protocol->id]) }}"> {{ trans('protocols.see_protocol_practices') }} </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link @if ($protocol->isClosed() || ! auth()->user()->can('print worksheets')) disabled @endif" target="_blank" href="{{ route('administrators/protocols/generate_worksheet', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_worksheet') }} </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link @if ($protocol->isOpen() || ! auth()->user()->can('print protocols')) disabled @endif" target="_blank" href="{{ route('administrators/protocols/generate_protocol', ['id' => $protocol->id]) }}"> {{ trans('protocols.generate_protocol') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($protocol->isOpen()) disabled @endif" href="#" onclick="sendEmailProtocol()"> {{ trans('protocols.send_protocol_to_email') }} </a>

            <form method="post" action="{{ route('administrators/protocols/send_protocol_to_email', ['id' => $protocol->id]) }}" id="send_email_protocol">
                @csrf

                <input type="submit" class="d-none">
            </form>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (! auth()->user()->can('manage patients')) disabled @endif" href="{{ route('administrators/patients/edit', ['id' => $protocol->internal_patient_id]) }}"> {{ trans('protocols.see_patient') }} </a>
        </li>

        <li class="nav-item @if ($protocol->isClosed()) disabled @endif">
            <a class="nav-link @if ($protocol->isClosed()) disabled @endif" href="#" onclick="closeProtocol()"> {{ trans('protocols.close_protocol') }} </a>

            <form method="post" action="{{ route('administrators/protocols/close', ['id' => $protocol->id]) }}" id="close_protocol">
                @csrf    
                
                <input class="d-none" type="submit">
            </form>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-pen-to-square"></i> {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('protocols.protocols_edit_message') }}
</p>
@endsection

@section('content')
@if (sizeof($errors) == 0)
    @if ($protocol->isOpen())
	<div id="securityMessage" class="alert alert-info fade show mt-4">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-primary btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('protocols.protocol_blocked') }}
	</div>
    @else
    <div class="alert alert-warning fade show mt-4">
		{{ trans('protocols.protocol_closed_message') }}
	</div>    
    @endif
@endif

<form method="post" action="{{ route('administrators/protocols/update', ['id' => $protocol->id]) }}">
    @csrf
    {{ method_field('PUT') }}

    <div class="mt-4">
        <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="patientAutoComplete"> {{ trans('patients.patient') }} </label>
                <input type="text" class="form-control" id="patientAutoComplete" value="{{ $protocol->internalPatient->full_name }}" aria-describedby="patientHelp" disabled>

                <small id="patientHelp" class="form-text text-muted"> {{ trans('protocols.patient_help') }} </small>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') ?? $protocol->prescriber->full_name }}" aria-describedby="prescriberHelp" required disabled>
                <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') ?? $protocol->prescriber_id }}"> 
                
                <div>
                    <small id="prescriberHelp" class="form-text text-muted"> {{ trans('protocols.prescriber_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-2">
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $protocol->plan->social_work->name }}" aria-describedby="socialWorkHelp" required disabled>

                <div>
                    <small id="socialWorkHelp" class="form-text text-muted"> {{ trans('protocols.social_work_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-2">
            <div class="form-group">
                <label for="expiration_date"> {{ trans('plans.plan') }} </label>
                <input type="text" class="form-control" name="plan_name" id="planAutoComplete" value="{{ old('plan_name') ?? $protocol->plan->name }}" aria-describedby="planHelp" disabled>
                <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $protocol->plan_id }}">
                
                <div>
                    <small id="planHelp" class="form-text text-muted"> {{ trans('protocols.plan_help') }} </small>
                </div>
		    </div>
        </div>

        <div class="col-md-6 mt-2">
            <div class="form-group">
                <label for="completion_date"> {{ trans('protocols.completion_date') }} </label>
                <input type="date" class="form-control" name="completion_date" id="completion_date" value="{{ old('completion_date') ?? $protocol->completion_date }}" aria-describedby="completionDateHelp" disabled>
                
                <small id="completionDateHelp" class="form-text text-muted"> {{ trans('protocols.completion_date_help') }} </small>
            </div>
        </div>

        <div class="col-md-6 mt-2">
            <div class="form-group">
                <label for="diagnostic"> {{ trans('protocols.diagnostic') }} </label>
                <input type="text" class="form-control" name="diagnostic" id="diagnostic" value="{{ old('diagnostic') ?? $protocol->diagnostic }}" aria-describedby="diagnosticHelp" disabled>
                
                <small id="diagnosticHelp" class="form-text text-muted"> {{ trans('protocols.diagnostic_help') }} </small>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.billing_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <input type="text" class="form-control" id="billingPeriodAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $protocol->billingPeriod->name }}" aria-describedby="billingPeriodHelp" disabled>
                <input type="hidden" name="billing_period_id" id="billing_period_id" value="{{ old('billing_period_id') ?? $protocol->billing_period_id }}"> 
                
                <div>
                    <small id="billingPeriodHelp" class="form-text text-muted"> {{ trans('protocols.billing_period_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="quantity_orders"> {{ trans('protocols.quantity_orders') }} </label>
                <input type="number" class="form-control" name="quantity_orders" id="quantity_orders" min="0" value="{{ old('quantity_orders') ?? $protocol->quantity_orders }}" aria-describedby="quantityOrdersHelp" required disabled>

                <small id="quantityOrdersHelp" class="form-text text-muted"> {{ trans('protocols.quantity_orders_help') }} </small>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="form-group">
            <h4> <i class="fa-solid fa-magnifying-glass"></i> <label for="observations"> {{ trans('protocols.observations') }} </label> </h4>
            <hr class="col-6">

            <textarea class="form-control" rows="3" name="observations" id="observations" aria-describedby="observationsHelp" disabled>{{ old('observations') ?? $protocol->observations }}</textarea>

            <small id="observationsHelp" class="form-text text-muted"> {{ trans('protocols.observations_help') }} </small>
        </div>
    </div>

    @if ($protocol->isOpen())
    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}" disabled>
    @endif
</form>
@endsection