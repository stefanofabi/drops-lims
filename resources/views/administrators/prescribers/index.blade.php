@extends('administrators/default-template')

@section('title')
{{ trans('prescribers.prescribers') }}
@endsection

@section('active_prescribers', 'active')

@section('js')
<script type="text/javascript">
	function load(page) {
		$("#page" ).val(page);
	    document.all["select_page"].submit();
	}

	function destroyPrescriber(form_id){
		if (confirm('{{ trans("forms.confirm") }}')) {
		    var form = document.getElementById('destroy_prescriber_'+form_id);
		    form.submit();
		}
	}
</script>

<script type="module">
    $(document).ready(function() {
        // Put the filter
        $("#filter" ).val('{{ $filter }}');
    });
</script>
@endsection

@section('menu')
<nav class="navbar bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/prescribers/create') }}"> {{ trans('prescribers.create_prescriber') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-user-md"></i> {{ trans('prescribers.prescribers') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('prescribers.prescribers_message') }}
</p>
@endsection

@section('content')
<form id="select_page">
	<!-- Filter by keys -->
	<div class="form-group row">
		<div class="mt-3 col-md-6">
			<input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
		</div>

		<div class="mt-3 col-md-6">
			<button type="submit" class="btn btn-primary" onclick="load(1)">
				<span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
			</div>
	</div>
	
	<input type="hidden" id="page" name="page" value="{{ $page }}">
</form>

<div class="table-responsive mt-3">
	<table class="table table-striped">
		<tr>
			<th> {{ trans('prescribers.prescriber') }} </th>
			<th> {{ trans('prescribers.primary_enrollment') }} </th>
			<th> {{ trans('prescribers.secondary_enrollment') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($prescribers as $prescriber)
			<tr>
				<td> {{ $prescriber->full_name }} </td>
				<td> {{ $prescriber->primary_enrollment }} </td>
				<td> {{ $prescriber->secondary_enrollment }} </td>

				<td class="text-end">
					<a href="{{ route('administrators/prescribers/edit', $prescriber->id) }}" class="btn btn-primary btn-sm" title="{{ trans('prescribers.edit_prescriber') }}" > <i class="fas fa-user-edit fa-sm"></i> </a>

					<a class="btn btn-primary btn-sm verticalButtons" title="{{ trans('prescribers.destroy_prescriber') }}" onclick="destroyPrescriber('{{ $prescriber->id }}')" > <i class="fas fa-user-slash fa-sm"></i> </a>

					<form id="destroy_prescriber_{{ $prescriber->id }}" method="POST" action="{{ route('administrators/prescribers/destroy', $prescriber->id) }}">
						@csrf
						@method('DELETE')
					</form>
				</td>
			</tr>
		@endforeach
	</table>	
</div>

{!! $paginate !!}
@endsection
