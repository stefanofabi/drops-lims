@extends('patients/index')

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Put the patient
            $("#patient" ).val('{{ $patient }}');
        });

        function load(page) {
            $("#page" ).val(page);
            document.all["select_page"].submit();
        }
    </script>
@endsection

@section('results')

    @if ($protocols->isEmpty())
        <div class="col-md-12"> {{ trans('forms.no_results') }}</div>
    @else

        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th> {{ trans('protocols.protocol_number') }} </th>
                    <th> {{ trans('protocols.completion_date') }} </th>
                    <th> {{ trans('patients.patient') }} </th>
                    <th> {{ trans('prescribers.prescriber') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>

                @foreach ($protocols as $protocol)
                    <tr>
                        <td> {{ $protocol->id }} </td>
                        <td> {{ date('d-m-Y', strtotime($protocol->completion_date)) }} </td>
                        <td> {{ $protocol->patient->full_name }} </td>
                        <td> {{ $protocol->prescriber->full_name }} </td>

                        <td class="text-end">
                            <a href="{{ route('patients/protocols/show', $protocol->id) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.show_protocol') }}" > <i class="fas fa-eye fa-sm"></i> </a>
                            <a target="_blank" href="{{ route('patients/protocols/print', $protocol->id) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.print_report') }}"> <i class="fas fa-print fa-sm"></i> </a>
                        </td>
                    </tr>
                @endforeach


                <tr>
                    <td colspan=7>
					<span class="float-end">

					</span>
                    </td>
                </tr>

            </table>
        </div>
    @endif
@endsection
