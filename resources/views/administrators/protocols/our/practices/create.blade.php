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

    function printSelection() 
    {
        $('#print_selection').submit();
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        @can('print_protocols')
        <li class="nav-item">
			<a class="nav-link" href="#" onclick="printSelection()"> {{ trans('protocols.print_selected') }} </a>
		</li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/our/edit', ['id' => $protocol->id]) }}"> {{ trans('forms.go_back') }} </a>
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
            <input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('practices.enter_practice') }}">
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary">
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

            <form id="print_selection" action="{{ route('administrators/protocols/our/print_selection') }}" method="post" target="_blank">
                @csrf

                <input type="hidden" name="id" value="{{ $protocol->id }}">

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
                        <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('practices.edit_practice') }}"> 
                            <i class="fas fa-edit fa-sm"></i> 
                        </a>

                        <a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('practices.destroy_practice') }}"> 
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

