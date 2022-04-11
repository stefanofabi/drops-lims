@extends('administrators/default-template')

@section('title')
{{ trans('practices.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    @if (empty($protocol->closed))
    $(function () {
        $("#practice").autocomplete({
            minLength: 2,
            source: function (event, ui) {
                var parameters = {
                    "nomenclator_id": '{{ $protocol->plan->nomenclator->id }}',
                    "filter": $("#practice").val()
                };

                $.ajax({
                    data: parameters,
                    url: '{{ route("administrators/protocols/practices/load_practices") }}',
                    type: 'post',
                    dataType: 'json',
                    success: ui
                });

                return ui;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#practice').val(ui.item.label);
                $('#report_id').val(ui.item.id);
            }
        });
    });

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
            "protocol_id": '{{ $protocol->id }}',
            "report_id": $("#report_id").val(),
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
                $('#report_id').val('');
            }
        });

        return false;
    }
    @endif

    function submitPracticesSelectForm(action) 
    {
        var checked = false;

        switch (action)
        {
            case 'print':
                { 
                    $("#practices_select_form").attr("action", "{{ route('administrators/protocols/print', ['id' => $protocol->id]) }}"); 
                    $("#practices_select_form").attr("method", "get");
                    $("#practices_select_form").attr("target", "blank");    
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
        @can('print_protocols')
        <li class="nav-item">
			<a class="nav-link" href="#" onclick="submitPracticesSelectForm('print')"> {{ trans('protocols.print_selected') }} </a>
		</li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" href="#" onclick="submitPracticesSelectForm('send')"> {{ trans('protocols.send_selected_practices_by_email') }} </a>
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

@section('content')
<div id="messages"></div>

<form onsubmit="return addPractice()">
    <div class="row mt-3">
        <div class="col">
            <input type="hidden" id="report_id" value="0">
            <input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('practices.enter_practice') }}" @if (! empty($protocol->closed)) readonly @endif>
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary @if (! empty($protocol->closed)) disabled @endif">
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
                <th> {{ trans('determinations.amount') }} </th>
                <th> {{ trans('practices.informed') }} </th>
                <th> {{ trans('practices.signed_off') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }}</th>
            </tr>

            @php
            $total_amount = 0;
            @endphp

            <form id="practices_select_form" action="" target="">
                <input type="hidden" id="csrf_token">

                @foreach ($protocol->practices as $practice)

                @php
                $total_amount += $practice->amount;
                @endphp
                
                <tr>
                    <td style="width: 50px"> <input type="checkbox" name="filter_practices[]" value="{{ $practice->id }}"> </td>
                    <td> {{ $practice->report->determination->code }} </td>
                    <td> {{ $practice->report->determination->name }} </td>
                    <td> ${{ number_format($practice->amount, 2, ",", ".") }} </td>
                    <td>
                        @if ($practice->results->isEmpty())
                        <span class="badge bg-primary"> {{ trans('forms.no') }} </span>
                        @else
                        <span class="badge bg-success"> {{ trans('forms.yes') }} </span>
                        @endif
                    </td>

                    <td>
                        @forelse($practice->signs as $sign)
                        <a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
                            <img height="30px" width="30px" src="{{ Gravatar::get($sign->user->email) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
                        </a>
                        @empty
                        {{ trans('practices.not_signed')}}
                        @endforelse
                    </td>
                                
                    <td class="text-end">
                        @if (empty($protocol->closed))
                        <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('practices.edit_practice') }}"> 
                            <i class="fas fa-edit fa-sm"></i> 
                        </a>
                        @else 
                        <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('practices.show_practice') }}"> 
                            <i class="fas fa-show fa-eye"></i> 
                        </a>
                        @endif

                        <a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}" class="btn btn-info btn-sm @if (! empty($protocol->closed)) disabled @endif" title="{{ trans('practices.destroy_practice') }}"> 
                            <i class="fas fa-trash fa-sm"></i> 
                        </a>
                    </td>
                </tr>
                @endforeach
            </form>

            <tr>
                <td colspan="7" class="text-end">
                    <h4> Total: ${{ number_format($total_amount, 2, ",", ".") }} </h4>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection

