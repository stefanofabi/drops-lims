@extends('administrators/default-template')

@section('title')
{{ trans('reports.index_reports') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">
    function destroyReport(form_id)
    {
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_report_' + form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
		<li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/reports/create', ['determination_id' => $determination->id]) }}"> {{ trans('reports.create_report') }} </a>
        </li>
		
		<li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/determinations/edit', ['id' => $determination->id]) }}"> {{ trans('forms.go_back') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-code"></i> {{ trans('reports.index_reports') }}
@endsection

@section('content')
<div class="table-responsive mt-3">
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

				<a class="btn btn-info btn-sm" title="{{ trans('reports.destroy_report') }}" onclick="destroyReport('{{ $report->id }}')">
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
@endsection

