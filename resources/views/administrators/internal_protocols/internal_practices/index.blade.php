@extends('administrators/default-template')

@section('title')
{{ trans('practices.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="module">
    $(document).ready(function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });

    const practiceAutoComplete = new autoComplete({
        selector: "#practice",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const source = await fetch(`{{ route("administrators/protocols/practices/load_practices") }}`, { 
                        method: 'POST', 
                        body: JSON.stringify({ "nomenclator_id": '{{ $protocol->plan->nomenclator_id }}', filter: $("#practice").val() }),
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
                    practiceAutoComplete.start();
                },
            },
        },
        resultItem: {
            element: (item, data) => {
                var price = data.value.biochemical_unit * {{ $protocol->plan->nbu_price }};
                // Modify Results Item Style
                item.style = "display: flex; justify-content: space-between;";
                // Modify Results Item Content
                item.innerHTML = `<span style="display: none"> {data.value.code} </span>
                <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                ${data.match}
                </span>
                <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
                $`+price+`
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

    practiceAutoComplete.input.addEventListener("selection", function (event) 
    {
        const feedback = event.detail;
        const selected = feedback.selection.value;

        $('#determination_id').val(selected.id);
        
        practiceAutoComplete.input.value = selected.name;

        addPractice();
    }); 
</script>

<script type="text/javascript">
    function addPractice() 
    {
        if (! $("#practice").val()) 
        {
            $("#practice").addClass('is-invalid');
            alert("{{ trans('practices.please_enter_practice') }}");

            return false;
        }

        $("#practice").removeClass('is-invalid');
            
        var parameters = {
            "_token": "{{ csrf_token() }}",
            "internal_protocol_id": '{{ $protocol->id }}',
            "determination_id": $("#determination_id").val(),
        };

        $.ajax({
            data: parameters,
            url: "{{ route('administrators/protocols/practices/store') }}",
            type: 'post',
            beforeSend: function () {
                $("#messages").html('<div class="spinner-border text-info"> </div> {{ trans("forms.please_wait") }}');
            },
            error: function (xhr, status) {
                $("#messages").html('<div class="alert alert-danger mt-3"> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.please_later")}}  </div> ');
            },
            success: function (response) {
                $("#messages").html('<div class="alert alert-success alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("practices.practice_loaded") }} </div>');
                $("#practices").load(" #practices");

                // delete data
                $('#practice').val('');
                $('#determination_id').val('');
            }
        });

        return false;
    }

    function submitPracticesSelectForm(action) 
    {
        var checked = false;

        switch (action)
        {
            case 'generate_protocol':
                { 
                    $("#practices_select_form").attr("action", "{{ route('administrators/protocols/generate_protocol', ['id' => $protocol->id]) }}"); 
                    $("#practices_select_form").attr("method", "get");
                    $("#practices_select_form").attr("target", "_blank");    
                    $('#csrf_token').attr('name', ''); 

                    break; 
                }

            case 'send': 
                { 
                    $("#practices_select_form").attr("action", "{{ route('administrators/protocols/send_protocol_to_email', ['id' => $protocol->id]) }}"); 
                    $("#practices_select_form").attr("method", "post");
                    $("#practices_select_form").attr("target", "");
                    $('#csrf_token').attr('name', '_token'); 
                    $('#csrf_token').val($('meta[name="csrf-token"]').attr('content'));   
                    
                    break; 
                }
        }

        $("input[name='filter_practices[]']:checkbox:checked").each(function() {
            checked = true;

            return false;
        });

        if (checked) 
        {
            $('#practices_select_form').submit();
        } else 
        {
            alert("{{ trans('protocols.not_selected_practices') }}");
        }
        
        return false;
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link @cannot('print protocols') disabled @endcannot" href="#" onclick="submitPracticesSelectForm('generate_protocol')"> {{ trans('protocols.generate_protocol_for_selected_practices') }} </a>
		</li>
        
        <li class="nav-item">
            <a class="nav-link @cannot('print protocols') disabled @endcannot" href="#" onclick="submitPracticesSelectForm('send')"> {{ trans('protocols.send_selected_practices_by_email') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/edit', ['id' => $protocol->id]) }}"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('practices.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('practices.practices_index_message') }}
</p>
@endsection

@section('content')
<div class="mt-3" id="messages"></div>

<form onsubmit="return addPractice()">
    <div class="row mt-3">
        <div class="col">
            <input type="hidden" id="determination_id" value="0">
            <input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('practices.enter_practice') }}" @if (! $protocol->isOpen()) readonly @endif>
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary @if (! $protocol->isOpen()) disabled @endif">
                <span class="fas fa-plus"></span> {{ trans('practices.add_practice') }}
            </button>
        </div>
    </div>
</form>

<div id="practices" class="mt-3">
    <div class="table-responsive">
        <table class="table table-striped">
            <tr class="info">
                <th> </th>
                <th> {{ trans('determinations.code') }} </th>
                <th> {{ trans('determinations.determination') }} </th>
                <th> {{ trans('practices.price') }} </th>
                <th> {{ trans('practices.informed') }} </th>
                <th> {{ trans('practices.signed_off') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }}</th>
            </tr>

            <form id="practices_select_form" action="" target="">
                <input type="hidden" id="csrf_token">

                @foreach ($protocol->internalPractices->sortBy(['determination.position', 'ASC']) as $practice)                
                <tr>
                    <td style="width: 50px"> <input type="checkbox" class="form-check-input" name="filter_practices[]" value="{{ $practice->id }}" @if ($practice->signInternalPractices->isEmpty()) disabled @endif> </td>
                    <td> {{ $practice->determination->code }} </td>
                    <td> {{ $practice->determination->name }} </td>
                    <td> ${{ number_format($practice->price, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }} </td>
                    <td>
                        @if ($practice->isInformed())
                        <span class="badge bg-success"> {{ trans('forms.yes') }} </span>
                        @else
                        <span class="badge bg-primary"> {{ trans('forms.no') }} </span>
                        @endif
                    </td>

                    <td>
                        @forelse($practice->signInternalPractices as $sign)
                        <a style="text-decoration: none" href="#" data-bs-toggle="tooltip" data-bs-title="{{ $sign->user->name }}">
                            <img height="30px" width="30px" src="{{ Gravatar::get($sign->user->email) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
                        </a>
                        @empty
                        {{ trans('practices.not_signed')}}
                        @endforelse
                    </td>
                                
                    <td class="text-end">
                        @if ($protocol->isOpen())
                        <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-primary btn-sm verticalButtons" title="{{ trans('practices.edit_practice') }}"> 
                            <i class="fas fa-edit fa-sm"></i> 
                        </a>
                        @else 
                        <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-primary btn-sm verticalButtons" title="{{ trans('practices.show_practice') }}"> 
                            <i class="fas fa-show fa-eye"></i> 
                        </a>
                        @endif

                        <a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}" class="btn btn-primary btn-sm verticalButtons @if (! $protocol->isOpen()) disabled @endif" title="{{ trans('practices.destroy_practice') }}"> 
                            <i class="fas fa-trash fa-sm"></i> 
                        </a>
                    </td>
                </tr>
                @endforeach
            </form>
        </table>

        <div class="float-end">
            <h4> Total: ${{ number_format($protocol->total_price, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }} </h4>
        </div>
    </div>
</div>
@endsection