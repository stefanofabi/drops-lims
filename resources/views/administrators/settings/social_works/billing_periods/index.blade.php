@extends('administrators/settings/index')

@section('title')
    {{ trans('billing_periods.billing_periods') }}
@endsection

@section('content-title')
    <i class="fas fa-layer-group"> </i> {{ trans('billing_periods.billing_periods') }}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#myBillingPeriodsTable').DataTable({
                "language": {
                    "info": '{{ trans('datatables.info') }}',
                    "infoEmpty": '{{ trans('datatables.info_empty') }}',
                    "infoFiltered": '{{ trans('datatables.info_filtered') }}',
                    "search": '{{ trans('datatables.search') }}',
                    "paginate": {
                        "first": '{{ trans('datatables.first') }}',
                        "last": '{{ trans('datatables.last') }}',
                        "previous": '{{ trans('datatables.previous') }}',
                        "next": '{{ trans('datatables.next') }}',
                    },
                    "lengthMenu": '{{ trans('datatables.show') }} '+
                        '<select class="form-control form-control-sm">'+
                        '<option value="10"> 10 </option>'+
                        '<option value="20"> 20 </option>'+
                        '<option value="30"> 30 </option>'+
                        '<option value="-1"> {{ trans('datatables.all') }} </option>'+
                        '</select> {{ trans('datatables.records') }}',
                    "emptyTable": '{{ trans('datatables.no_data') }}',
                    "zeroRecords": '{{ trans('datatables.no_match_records') }}',
                }
            });
        });

        function destroy_billing_period(form_id){
            if (confirm('{{ trans("forms.confirm") }}')) {
                var form = document.getElementById('destroy_billing_period_'+form_id);
                form.submit();
            }
        }
    </script>
@endsection

@section('header-content')
    <div class="btn-group float-right">
        <a href="{{ route('administrators/settings/social_works/billing_periods/create') }}" class="btn btn-info"> <span class="fas fa-plus"></span> {{ trans('billing_periods.create_billing_period') }} </a>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped" id="myBillingPeriodsTable">
            <thead>
                <tr>
                    <th> {{ trans('billing_periods.name') }} </th>
                    <th> {{ trans('billing_periods.start_date') }} </th>
                    <th> {{ trans('billing_periods.end_date') }} </th>
                    <th class="text-right"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($billing_periods as $billing_period)
                    <tr>
                        <td> {{ $billing_period->name }} </td>

                        <td> {{ date('d/m/Y', strtotime($billing_period->start_date)) }} </td>

                        <td> {{ date('d/m/Y', strtotime($billing_period->end_date)) }} </td>

                        <td class="text-right">
                            <a href="{{ route('administrators/settings/social_works/billing_periods/edit', ['id' => $billing_period->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('billing_periods.edit_billing_period') }}">
                                <i class="fas fa-edit fa-sm"> </i>
                            </a>

                            <a class="btn btn-info btn-sm" title="{{ trans('billing_periods.destroy_billing_period') }}"
                               onclick="destroy_social_work('{{ $billing_period->id }}')">
                                <i class="fas fa-trash fa-sm"></i>
                            </a>

                            <form id="destroy_social_work_{{ $billing_period->id }}" method="POST"
                                  action="{{ route('administrators/settings/social_works/billing_periods/destroy', ['id' => $billing_period->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
