@extends('administrators/default-template')

@section('title')
{{ trans('protocols.protocols') }}
@endsection

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">
	    $(document).ready(function() {
	        // Put the filter
	        $("#filter" ).val('{{ $data['filter'] ?? '' }}');
	    });

	    function load(page) {
	        $("#page" ).val(page);
	    	document.all["select_page"].submit();
	    }
    </script>
@endsection

@section('menu')
<nav class="navbar bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/protocols/our/create') }}"> {{ trans('protocols.create_protocol') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<span class="fas fa-file-medical" ></span> {{ trans('protocols.protocols') }}
@endsection

@section('content')
<!-- Filter by keys -->
<div class="form-group row mt-2">
    <div class="mt-2 col-md-6">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
    </div>

    <div class="mt-2 col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
        </div>
</div>

<div class="table-responsive mt-3">
	<table class="table table-striped">
		<tr>
			<th> {{ trans('protocols.protocol_number') }} </th>
			<th> {{ trans('patients.patient') }} </th>
			<th> {{ trans('protocols.completion_date') }} </th>
			<th> {{ trans('protocols.type') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($protocols as $protocol)
		<tr>
			<td> 
				{{ $protocol->id }} 

				@if (date('Y-m-d') == $protocol->completion_date) 
				<span class="badge bg-success bg-sm">New</span>
				@endif 
			</td>

			<td> {{ $protocol->patient }} </td>
			<td> @if ($protocol->completion_date) {{ date('d/m/Y', strtotime($protocol->completion_date)) }} @endif</td>
			<td> 
				@if ($protocol->type == 'our') 
				<span class="badge bg-primary">Our</span>
				@else 
				<span class="badge bg-secondary">Derived</span>
				@endif 
			</td>

			<td class="text-end">
				@if ($protocol->type == 'our')
				<a href="{{ route('administrators/protocols/our/edit', [$protocol->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_protocol') }}" > <i class="fas fa-edit fa-sm"></i> </a> 
				@else 
				<a href="" class="btn btn-info btn-sm" title="{{ trans('protocols.edit_protocol') }}" > <i class="fas fa-edit fa-sm"></i> </a> 
				@endif

				<a href="" class="btn btn-info btn-sm verticalButtons" title="{{ trans('protocols.destroy_protocol') }}"> <i class="fas fa-trash fa-sm"></i> </a>
			</td>
		</tr>
		@endforeach
	</table>
</div>

{!! $paginate !!}
@endsection