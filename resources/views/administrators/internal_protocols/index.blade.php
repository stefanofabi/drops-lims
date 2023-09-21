@extends('administrators/default-template')

@section('title')
{{ trans('protocols.protocols') }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="module">
	$(document).ready(function() 
	{
	    // Put the filter
	    $("#filter" ).val('{{ $filter }}');
	});
</script>

<script type="text/javascript">
	function load(page) 
	{
	    $("#page" ).val(page);
	    document.all["select_page"].submit();
	}

	function destroyInternalProtocol(form_id)
	{
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_internal_protocol_'+form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/create') }}"> {{ trans('protocols.create_protocol') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<span class="fas fa-file-medical" ></span> {{ trans('protocols.protocols') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('protocols.protocols_message') }}
</p>
@endsection

@section('content')
<form id="select_page">
	<!-- Filter by keys -->
	<div class="form-group row mt-2">
		<div class="mt-2 col-md-6">
			<input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
		</div>

		<div class="mt-2 col-md-6">
			<button type="submit" class="btn btn-primary" onclick="load(1)">
				<span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
			</div>
	</div>

	<input type="hidden" id="page" name="page" value="{{ $page }}">
</form>

<div class="table-responsive mt-3">
	<table class="table table-striped">
		<tr>
			<th> {{ trans('protocols.protocol_number') }} </th>
			<th> {{ trans('patients.patient') }} </th>
			<th> {{ trans('protocols.completion_date') }} </th>
			<th> {{ trans('prescribers.prescriber') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($protocols as $protocol)
		<tr>
			<td> 
				{{ $protocol->id }} 

				@if ($protocol->isClosed())
				<span class="badge bg-warning bg-sm"> {{ trans('protocols.closed') }} </span>
				@elseif (date('Y-m-d') == $protocol->completion_date) 
				<span class="badge bg-success bg-sm"> {{ trans('protocols.new') }} </span>
				@endif 
			</td>

			<td> {{ $protocol->patient }} </td>
			<td> {{ \Carbon\Carbon::parse($protocol->completion_date)->format(Drops::getSystemParameterValueByKey('DATE_FORMAT')) }} </td>
			<td> {{ $protocol->prescriber }} </td>

			<td class="text-end">
				@if ($protocol->isOpen())
				<a href="{{ route('administrators/protocols/edit', [$protocol->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('protocols.edit_protocol') }}" > <i class="fas fa-edit fa-sm"></i> </a>
				<a href="#" class="btn btn-primary btn-sm verticalButtons" title="{{ trans('protocols.destroy_protocol') }}" onclick="destroyInternalProtocol('{{ $protocol->id }}')"> <i class="fas fa-trash fa-sm"></i> </a> 

				<form id="destroy_internal_protocol_{{ $protocol->id }}" method="POST" action="{{ route('administrators/protocols/destroy', $protocol->id) }}">
					@csrf
					@method('DELETE')
				</form>
				@else
				<a href="{{ route('administrators/protocols/edit', [$protocol->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('protocols.show_protocol') }}" > <i class="fas fa-eye fa-sm"></i> </a> 
				<a href="#" class="btn btn-primary btn-sm verticalButtons disabled" title="{{ trans('protocols.destroy_protocol') }}"> <i class="fas fa-trash fa-sm"></i> </a>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
</div>

{!! $paginate !!}
@endsection