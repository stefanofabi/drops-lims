@extends('administrators/settings/index')

@section('title')
    {{ trans('nomenclators.nomenclators') }}
@endsection

@section('js')
<script type="module">
    $('#myNomenclatorsTable').DataTable({
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
        }
    });
</script>
    
<script type="text/javascript">
    function destroyNomenclator(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_nomenclator_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('content-title')
<i class="fas fa-book-medical"> </i> {{ trans('nomenclators.nomenclators') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('nomenclators.nomenclators_index_message') }} 

    <a class="link-light" href="{{ route('administrators/settings/nomenclators/create') }}"> {{ trans('nomenclators.click_to_create_nomenclator') }} </a>
</p>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-striped" id="myNomenclatorsTable">
            <thead>
            <tr>
                <th> {{ trans('nomenclators.name') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }} </th>
            </tr>
            </thead>

            <tbody>
                @foreach ($nomenclators as $nomenclator)
                <tr>
                    <td> {{ $nomenclator->name }} </td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/nomenclators/edit', ['id' => $nomenclator->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('nomenclators.edit_nomenclator') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-primary btn-sm" title="{{ trans('nomenclators.destroy_nomenclator') }}" onclick="destroyNomenclator('{{ $nomenclator->id }}')">
                            <i class="fas fa-trash fa-sm"></i>
                        </a>

                        <form id="destroy_nomenclator_{{ $nomenclator->id }}" method="POST" action="{{ route('administrators/settings/nomenclators/destroy', ['id' => $nomenclator->id]) }}">
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
