@extends('administrators/settings/index')

@section('title')
    {{ trans('social_works.social_works') }}
@endsection

@section('js')
<script type="module">
    $(document).ready(function () {
        $('#mySocialWorksTable').DataTable({
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
    });
</script>

<script type="text/javascript">
    function destroySocialWork(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_social_work_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('content-title')
    <i class="fas fa-heartbeat"> </i> {{ trans('social_works.social_works') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('social_works.social_works_message') }}    

    <a class="link-light" href="{{ route('administrators/settings/social_works/create') }}"> {{ trans('social_works.click_to_create_social_work') }} </a>
</p>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-striped" id="mySocialWorksTable">
            <thead>
                <tr>
                    <th> {{ trans('social_works.name') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($social_works as $social_work)
                <tr>
                    <td> {{ $social_work->name }} </td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/social_works/edit', ['id' => $social_work->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('social_works.edit_social_work') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-primary btn-sm" title="{{ trans('social_works.destroy_social_work') }}" onclick="destroySocialWork('{{ $social_work->id }}')">
                            <i class="fas fa-trash fa-sm"></i>
                        </a>

                        <form id="destroy_social_work_{{ $social_work->id }}" method="POST" action="{{ route('administrators/settings/social_works/destroy', ['id' => $social_work->id]) }}">
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
