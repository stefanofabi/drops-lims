@extends('administrators/default-template')

@section('title')
{{ trans('patients.patients') }}
@endsection

@section('js')
<script type="text/javascript">
    function destroyPatient(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_patient_'+form_id);
            form.submit();
        }
    }
    function load(page) {
        $("#page" ).val(page);
        document.all["select_page"].submit();
    }
</script>

<script type="module">
    $(document).ready(function() {
        // Put the filter
        $("#filter" ).val("{{ $filter }}");
    });
</script>
@endsection

@section('active_patients', 'active')

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/create') }}"> {{ trans('patients.create_patient') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.patients') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('patients.patients_message') }}
</p>
@endsection

@section('content')
<form id="select_page">
    <!-- Filter by keys -->
    <div class="form-group row">
        <div class="mt-3 col-md-6">
            <input type="text" class="form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
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
			<th> {{ trans('patients.patient') }} </th>
			<th> {{ trans('patients.identification_number') }} </th>
			<th> {{ trans('patients.city') }} </th>
			<th> {{ trans('social_works.social_work') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }} </th>
		</tr>

		@foreach ($patients as $patient)
		<tr>
			<td> {{ $patient->full_name }} </td>
			<td> {{ $patient->identification_number }} </td>
			<td> {{ $patient->city }} </td>
			<td>
                {{ $patient->plan->social_work->name  ?? '' }}
            </td>

			<td class="text-end">
				<a href="{{ route('administrators/patients/edit', $patient->id) }}" class="btn btn-primary btn-sm verticalButtons" title="{{ trans('patients.edit_patient') }}" > <i class="fas fa-user-edit fa-sm"></i> </a>

				<a class="btn btn-primary btn-sm verticalButtons" title="{{ trans('patients.destroy_patient') }}" onclick="destroyPatient('{{ $patient->id }}')"> <i class="fas fa-user-slash fa-sm"> </i> </a>

				<form id="destroy_patient_{{ $patient->id }}" method="POST" action="{{ route('administrators/patients/destroy', $patient->id) }}">
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