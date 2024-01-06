@extends('administrators/settings/index')

@section('title')
{{ trans('billing_periods.billing_periods') }}
@endsection

@section('js')
<script type="module">
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
                    '<select class="form-select form-select-sm">'+
                    '<option value="10"> 10 </option>'+
                    '<option value="20"> 20 </option>'+
                    '<option value="30"> 30 </option>'+
                    '<option value="-1"> {{ trans('datatables.all') }} </option>'+
                    '</select> {{ trans('datatables.records') }}',
                "emptyTable": '{{ trans('datatables.no_data') }}',
                "zeroRecords": '{{ trans('datatables.no_match_records') }}',
            },
            "order": [
                [1, "desc"]
            ]
        });
    });
</script>

<script type="text/javascript">
    function destroyBillingPeriod(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_billing_period_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('content-title')
<i class="fa-solid fa-calendar-days"></i> {{ trans('billing_periods.billing_periods') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('billing_periods.billing_periods_message') }}    

    <a class="link-light" href="{{ route('administrators/settings/billing_periods/create') }}"> {{ trans('billing_periods.click_to_create_billing_period') }} </a>
</p>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-striped" id="myBillingPeriodsTable">
            <thead>
                <tr>
                    <th> {{ trans('billing_periods.name') }} </th>
                    <th> {{ trans('billing_periods.start_date') }} </th>
                    <th> {{ trans('billing_periods.end_date') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                    @foreach ($billing_periods as $billing_period)
                    <tr>
                        <td> {{ $billing_period->name }} </td>
                        <td> {{ \Carbon\Carbon::parse($billing_period->start_date)->format(Drops::getSystemParameterValueByKey('DATE_FORMAT')) }} </td>
                        <td> {{ \Carbon\Carbon::parse($billing_period->end_date)->format(Drops::getSystemParameterValueByKey('DATE_FORMAT')) }} </td>

                        <td class="text-end">
                            <a href="{{ route('administrators/settings/billing_periods/edit', ['id' => $billing_period->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('billing_periods.edit_billing_period') }}">
                                <i class="fas fa-edit fa-sm"> </i>
                            </a>

                            <a class="btn btn-primary btn-sm" title="{{ trans('billing_periods.destroy_billing_period') }}" onclick="destroyBillingPeriod('{{ $billing_period->id }}')">
                                <i class="fas fa-trash fa-sm"></i>
                            </a>

                            <form id="destroy_billing_period_{{ $billing_period->id }}" method="POST" action="{{ route('administrators/settings/billing_periods/destroy', ['id' => $billing_period->id]) }}">
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
