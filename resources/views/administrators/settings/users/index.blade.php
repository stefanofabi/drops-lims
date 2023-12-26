@extends('administrators/settings/index')

@section('title')
    {{ trans('users.users') }}
@endsection

@section('js')
<script type="module">
    $('#myUsersTable').DataTable({
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
    function destroyUser(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_user_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/users/create') }}"> {{ trans('users.create_user')}} </a>
		</li>
        
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/index') }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-users"></i> {{ trans('users.users') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('users.users_index_content_message') }}
</p>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-striped" id="myUsersTable">
            <thead>
            <tr>
                <th> {{ trans('users.full_name') }} </th>
                <th> {{ trans('users.email') }} </th>
                <th> {{ trans('auth.last_login') }} </th>
                <th class="text-end"> {{ trans('forms.actions') }} </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td> {{ $user->full_name }} @if ($user->isBanned()) <span class="badge text-bg-danger"> {{ trans('bans.banned') }}</span>  @endif </td>

                    <td> {{ $user->email }} </td>

                    <td> @if (! empty($user->last_login_at)) {{ $user->last_login_at->diffForHumans() }} @endif</td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/users/edit', ['id' => $user->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('users.show_user') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-primary btn-sm" title="{{ trans('users.destroy_user') }}" onclick="destroyUser('{{ $user->id }}')">
                            <i class="fas fa-trash fa-sm"></i>
                        </a>

                        <form id="destroy_user_{{ $user->id }}" method="POST" action="{{ route('administrators/settings/users/destroy', ['id' => $user->id]) }}">
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
