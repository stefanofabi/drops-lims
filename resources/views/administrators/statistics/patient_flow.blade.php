@extends('administrators.statistics.index')

@section('js')
<script type="module">
    const startBillingPeriodAutoComplete = new autoComplete({
        selector: "#startBillingPeriodAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/billing_periods/load_billing_periods") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#startBillingPeriodAutoComplete").val() }),
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
                    startBillingPeriodAutoComplete.start();
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

    startBillingPeriodAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        startBillingPeriodAutoComplete.input.blur();

        const selected = feedback.selection.value;

        $('#start_billing_period_id').val(selected.id);
    
        startBillingPeriodAutoComplete.input.value = selected.name;
    });

    const endBillingPeriodAutoComplete = new autoComplete({
        selector: "#endBillingPeriodAutoComplete",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/settings/billing_periods/load_billing_periods") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ filter: $("#endBillingPeriodAutoComplete").val() }),
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
                    endBillingPeriodAutoComplete.start();
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

    endBillingPeriodAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        endBillingPeriodAutoComplete.input.blur();

        const selected = feedback.selection.value;

        $('#end_billing_period_id').val(selected.id);
    
        endBillingPeriodAutoComplete.input.value = selected.name;
    });
</script>

@if (isset($patient_flow))
<script type="module">
  GoogleCharts.load(drawChart);

  function drawChart() 
  {
    const data = GoogleCharts.api.visualization.arrayToDataTable([
      [
        'Billing periods', 'Total'],

        @foreach ($patient_flow as $billing_period)
        ['{{ $billing_period->name }}', {{ $billing_period->total }}],
        @endforeach
    ]);

    var options = {
        title: '{{ trans("statistics.patient_flow") }}',
        hAxis: {title: '{{ trans("billing_periods.billing_periods") }}',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
    };

    var chart = new GoogleCharts.api.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
@endif
@endsection

@section('content')
<div class="mt-3"> 
    <h2> {{ trans('statistics.patient_flow') }} </h2> 
    <hr class="col-6">
    <p class="col-9"> {{ trans('statistics.patient_flow_message') }} </p>
</div>

<form action="{{ route('administrators/statistics/patient_flow/generate_chart') }}" method="post">
    @csrf

    <div class="row">
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <input type="text" class="form-control" id="startBillingPeriodAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $start_billing_period->name ?? '' }}" aria-describedby="startBillingPeriodHelp" required>
                <input type="hidden" name="start_billing_period_id" id="start_billing_period_id" value="{{ $start_billing_period->id ?? '' }}"> 
                        
                <div>
                    <small id="startBillingPeriodHelp" class="form-text text-muted"> The billing period you start filtering </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <input type="text" class="form-control" id="endBillingPeriodAutoComplete" placeholder="{{ trans('forms.start_typing') }}" value="{{ $end_billing_period->name ?? '' }}" aria-describedby="endBillingPeriodHelp" required>
                <input type="hidden" name="end_billing_period_id" id="end_billing_period_id" value="{{ $end_billing_period->id ?? '' }}"> 
                        
                <div>
                <small id="endBillingPeriodHelp" class="form-text text-muted"> The billing period you end filtering </small>
                </div>
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-primary mt-3" value="{{ trans('statistics.generate_chart') }}">
</form>

@if (isset($patient_flow))
<div class="mt-5" id="chart_div" style="width: 800px; height: 500px;"></div>
@endif
@endsection

