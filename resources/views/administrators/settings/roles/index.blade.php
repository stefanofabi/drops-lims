@extends('administrators/settings/index')

@section('title')
    {{ trans('roles.roles') }}
@endsection

@section('js')
<script type="module">
    $('#myRolesTable').DataTable({
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
    function destroyRole(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_role_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/roles/create') }}"> {{ trans('roles.create_role')}} </a>
		</li>
        
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-user-group"></i> {{ trans('roles.roles') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('roles.roles_index_content_message') }}
</p>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-striped" id="myRolesTable">
            <thead>
            <tr>
                <th> {{ trans('roles.name') }} </th>
                <th> {{ trans('roles.access_environment') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }} </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td> {{ $role->name }}  @if ($role->hasPermissionTo('is lab staff')) <span class="badge text-bg-danger"> {{ trans('roles.danger') }} </span> @endif </td>

                    <td> 
                        @if ($role->hasPermissionTo('is lab staff')) {{ trans('roles.is_lab_staff') }} @endif 
                        @if ($role->hasPermissionTo('is patient')) {{ trans('roles.is_patient') }} @endif 
                    </td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/roles/edit', ['id' => $role->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('roles.show_role') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-primary btn-sm" title="{{ trans('roles.destroy_role') }}" onclick="destroyRole('{{ $role->id }}')">
                            <i class="fas fa-trash fa-sm"></i>
                        </a>

                        <form id="destroy_role_{{ $role->id }}" method="POST" action="{{ route('administrators/settings/roles/destroy', ['id' => $role->id]) }}">
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
