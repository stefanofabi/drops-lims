@extends('administrators/default-template')

@section('title')
    {{ trans('protocols.edit_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">
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
                    $("#messages").html('<div class="alert alert-danger"> <strong> {{ trans("forms.danger") }}! </strong> {{ trans("forms.please_later")}}  </div> ');
                },
                success: function (response) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible fade show mt-3" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> <strong> {{ trans("forms.well_done") }}! </strong> {{ trans("protocols.practice_loaded") }} </div>');
                    $("#practices").load(" #practices");

                    // delete data
                    $('#practice').val('');
                    $('#report_id').val('');
                }
            });

            return false;
        }
    </script>
@endsection

@section('menu')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('administrators/protocols/our/edit', ['id' => $protocol->id]) }}"> {{ trans('forms.go_back') }} </a>
    </li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.add_practices_for_protocol') }} #{{ $protocol->id }}
@endsection

@section('content')
<div id="messages"></div>

<form onsubmit="return addPractice()">
    <div class="row mt-3">
        <div class="col">
            <input type="hidden" id="report_id" value="0">
            <input type="text" class="form-control input-sm" id="practice" placeholder="{{ trans('protocols.enter_practice') }}">
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-plus"></span> {{ trans('protocols.add_practice') }}
            </button>
        </div>
    </div>
</form>

        <div id="practices" class="mt-3">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr class="info">
                        <th> {{ trans('determinations.code') }} </th>
                        <th> {{ trans('determinations.determination') }} </th>
                        <th> {{ trans('determinations.amount') }} </th>
                        <th> {{ trans('protocols.informed') }} </th>
                        <th class="text-right"> {{ trans('forms.actions') }}</th>
                    </tr>

                    @php
                        use App\Http\Controllers\OurProtocolController;
                        $total_amount = 0;
                    @endphp

                    @foreach ($protocol->practices as $practice)

                        @php
                            $total_amount += $practice->amount;
                        @endphp
                        <tr>
                            <td> {{ $practice->report->determination->code }} </td>
                            <td> {{ $practice->report->determination->name }} </td>
                            <td> ${{ number_format($practice->amount, 2, ",", ".") }} </td>
                            <td>
                                @if ($practice->results->isEmpty())
                                    <span class="badge badge-primary"> {{ trans('forms.no') }} </span>
                                @else
                                    <span class="badge badge-success"> {{ trans('forms.yes') }} </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('administrators/protocols/practices/edit', ['id' => $practice->id]) }}"
                                   class="btn btn-info btn-sm" title="{{ trans('protocols.edit_practice') }}"> <i
                                        class="fas fa-edit fa-sm"></i> </a>
                                <a href="{{ route('administrators/protocols/practices/destroy', ['id' => $practice->id]) }}"
                                   class="btn btn-info btn-sm" title="{{ trans('protocols.destroy_practice') }}"> <i
                                        class="fas fa-trash fa-sm"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="5" class="text-right">
                            <h4> Total: ${{ number_format($total_amount, 2, ",", ".") }} </h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

