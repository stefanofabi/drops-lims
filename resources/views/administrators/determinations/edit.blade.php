@extends('administrators/default-template')

@section('title')
    {{ trans('determinations.edit_determination') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">
	var enableForm = false;

	$(document).ready(function() {
		@if (sizeof($errors) > 0)
		enableSubmitForm();
		@endif
    });

	function enableSubmitForm() 
	{
		$('#securityMessage').hide('slow');

		$("input").removeAttr('readonly');
		$("select").removeAttr('disabled');

		$("#submitButtonVisible").removeClass('disabled');

		enableForm = true;
	}

	function submitForm() 
	{
		if (enableForm) 
		{
			let submitButton = $('#submit-button');
            submitButton.click();
		}
    }

    function destroy_report(form_id)
    {
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_report_' + form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    <ul class="nav flex-column">
        @can('crud_reports')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrators/determinations/reports/create', ['determination_id' => $determination->id]) }}">
                    <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('reports.create_report') }} </a>
            </li>
        @endcan
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-edit"></i> {{ trans('determinations.edit_determination') }}
@endsection


@section('content')
@if (sizeof($errors) == 0)
	<div id="securityMessage" class="alert alert-info fade show">
		<button type="submit" onclick="enableSubmitForm()" class="btn btn-info btn-sm">
			<i class="fas fa-lock-open"></i>
		</button>

		{{ trans('determinations.determination_blocked') }}
	</div>
@endif

<form method="post" action="{{ route('administrators/determinations/update', $determination->id) }}">
    @csrf
     {{ method_field('PUT') }}

    <div class="col-10">
		<h4><i class="fas fa-book-medical"></i> {{ trans('determinations.determination_data') }} </h4>
		<hr class="col-6">

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
			</div>

			<input type="text" class="form-control" value="{{ $determination->nomenclator->name }}" disabled>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.code') }} </span>
			</div>

			<input type="number" class="form-control @error('code') is-invalid @enderror" name="code" min="0" value="{{ old('code') ?? $determination->code }}" required readonly>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.name') }} </span>
			</div>

			<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $determination->name }}" required readonly>
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.position') }} </span>
			</div>

			<input type="number" class="form-control @error('position') is-invalid @enderror" name="position" min="1" value="{{ old('position') ?? $determination->position }}" required readonly> 
		</div>

		<div class="input-group mt-2">
			<div class="input-group-prepend">
				<span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
			</div>

			<input type="number" class="form-control @error('biochemical_unit') is-invalid @enderror" name="biochemical_unit" min="0" step="0.01" value="{{ old('biochemical_unit') ?? $determination->biochemical_unit }}" required readonly>
		</div>
	</div>
    
    <input id="submit-button" type="submit" style="display: none;">
</form>
@endsection

@section('content-footer')
<div class="card-footer">
	<div class="float-end">
		<button type="submit" class="btn btn-primary" onclick="submitForm()">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>
</div>
@endsection

@section('extra-content')
<div class="card margins-boxs-tb mb-3">
	<div class="card-header">
		<h4><span class="fas fa-file-alt"></span> {{ trans('reports.index_reports')}} </h4>
	</div>

	<div class="table-responsive">
		<table class="table table-striped">
			<tr class="info">
				<th> {{ trans('reports.name') }} </th>
				<th class="text-end"> {{ trans('forms.actions') }}</th>
			</tr>
			@foreach ($determination->reports as $report)
			<tr>
				<td> {{ $report->name }} </td>
				<td class="text-end">
					<a href="{{ route('administrators/determinations/reports/edit', ['id' => $report->id]) }}" class="btn btn-info btn-sm" title="{{ trans('reports.edit_report') }}"> 
					    <i class="fas fa-edit fa-sm"></i> 
					</a>

					<a class="btn btn-info btn-sm" title="{{ trans('reports.destroy_report') }}" onclick="destroy_report('{{ $report->id }}')">
					    <i class="fas fa-trash fa-sm"></i> 
					</a>
                    
					<form id="destroy_report_{{ $report->id }}" method="POST" action="{{ route('administrators/determinations/reports/destroy', ['id' => $report->id]) }}">
						@csrf
						@method('DELETE')
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection
