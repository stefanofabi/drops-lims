@extends('administrators/default-template')

@section('title')
    {{ trans('protocols.create_protocol') }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="module">
    const patientAutoComplete = new autoComplete({
        selector: "#patientAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/patients/load_patients") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#patientAutoComplete").val() }),
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
                    patientAutoComplete.start();
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
                ${data.value.identification_number}
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

    patientAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        patientAutoComplete.input.blur();

        const selected = feedback.selection.value;

        $('#patient').val(selected.id);
    
        patientAutoComplete.input.value = selected.full_name;

        $('#submitPatient').click();
    });

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
@endsection

@section('content-title')
    <i class="fas fa-file-medical"></i> {{ trans('protocols.create_protocol') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('protocols.protocols_create_message') }}
</p>
@endsection

@section('content')
@if (!empty($patient))
    @if (empty($patient->plan_id))
    <div class="alert alert-warning mt-4">
        <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.unloaded_social_work') }}
    </div>
    @elseif ($patient->expiration_date < date('Y-m-d'))
    <div class="alert alert-warning mt-4">
        <strong>{{ trans('forms.warning') }}!</strong> {{ trans('protocols.expired_social_work') }}
    </div>
    @endif
@else
<div class="alert alert-info mt-4">
    <strong>{{ trans('forms.information') }}!</strong> {{ trans('protocols.create_notice') }}
</div>
@endif

<form action="{{ route('administrators/protocols/create') }}">
    <input type="hidden" name="internal_patient_id" id="patient">

    <input type="submit" class="d-none" id="submitPatient">
</form>

<form method="post" action="{{ route('administrators/protocols/store') }}">
    @csrf

    <div class="mt-4">
        <h4><i class="fas fa-book"></i> {{ trans('protocols.medical_order_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row mt-2">
        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" class="form-control" id="patientAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $patient->full_name ?? '' }}" aria-describedby="patientHelp" required>
                <input type="hidden" name="internal_patient_id" value="{{ $patient->id ?? '' }}"> 
                
                <div>
                    <small id="patientHelp" class="form-text text-muted"> {{ trans('protocols.patient_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <input type="text" class="form-control" name="prescriber_name" id="prescriberAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('prescriber_name') }}" aria-describedby="prescriberHelp" required>
                <input type="hidden" id="prescriber" name="prescriber_id" value="{{ old('prescriber_id') }}"> 
                
                <div>
                    <small id="prescriberHelp" class="form-text text-muted"> {{ trans('protocols.prescriber_help') }} </small>
                </div>
            </div>
        </div>
   
        <div class="col-lg-6 mt-2">
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="social_work_name" id="socialWorkAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ old('social_work_name') ?? $patient->plan->social_work->name ?? '' }}" aria-describedby="socialWorkHelp" required>
                
                <div>
                    <small id="socialWorkHelp" class="form-text text-muted"> {{ trans('protocols.social_work_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-2">
            <div class="form-group">
                <label for="expiration_date"> {{ trans('plans.plan') }} </label>
                <input type="text" class="form-control" name="plan_name" id="planAutoComplete" value="{{ old('plan_name') ?? $patient->plan->name ?? '' }}" aria-describedby="planHelp" disabled>
                <input type="hidden" name="plan_id" id="plan" value="{{ old('plan_id') ?? $patient->plan_id ?? '' }}">
                
                <div>
                    <small id="planHelp" class="form-text text-muted"> {{ trans('protocols.plan_help') }} </small>
                </div>
		    </div>
        </div>
   
        <div class="col-lg-6">
            <div class="form-group mt-2">
                <label for="completion_date"> {{ trans('protocols.completion_date') }} </label>
                <input type="date" class="form-control" name="completion_date" id="completion_date" value="{{ old('completion_date') ?? date('Y-m-d') }}" aria-describedby="completionDateHelp">
                    
                <small id="completionDateHelp" class="form-text text-muted"> {{ trans('protocols.completion_date_help') }} </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="diagnostic"> {{ trans('protocols.diagnostic') }} </label>
                <input type="text" class="form-control" name="diagnostic" id="diagnostic" value="{{ old('diagnostic') }}" aria-describedby="diagnosticHelp">

                <small id="diagnosticHelp" class="form-text text-muted"> {{ trans('protocols.diagnostic_help') }} </small>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4><i class="fas fa-file-invoice-dollar"></i> {{ trans('protocols.billing_data') }} </h4>
        <hr class="col-6">
    </div>

    <div class="row">
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <input type="text" class="form-control" id="billingPeriodAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $current_billing_period->name ?? '' }}" aria-describedby="billingPeriodHelp" required>
                <input type="hidden" name="billing_period_id" id="billing_period_id" value="{{ old('billing_period_id') ?? $current_billing_period->id ?? '' }}"> 
                
                <div>
                    <small id="billingPeriodHelp" class="form-text text-muted"> {{ trans('protocols.billing_period_help') }} </small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="quantity_orders"> {{ trans('protocols.quantity_orders') }} </label>
                <input type="number" class="form-control" name="quantity_orders" id="quantity_orders" min="0" value="{{ old('quantity_orders') ?? '1' }}" aria-describedby="quantityOrdersHelp" required>

                <small id="quantityOrdersHelp" class="form-text text-muted"> {{ trans('protocols.quantity_orders_help') }} </small>
            </div>
        </div>
    </div>
        
    <input type="submit" class="btn btn-lg btn-primary float-start mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection