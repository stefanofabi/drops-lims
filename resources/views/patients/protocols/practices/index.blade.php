@extends('patients/default-template')

@section('title')
{{ trans('practices.index_practices') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function printSelection() {
        $('#print_selection').submit();
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="#" onclick="printSelection()"> {{ trans('protocols.generate_protocol_for_selected_practices') }} </a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('patients/protocols/show', ['id' => $protocol->id]) }}"> {{ trans('forms.go_back') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('practices.index_practices_for_protocol', ['id' => $protocol->id]) }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('practices.index_practices_message') }}
</p>
@endsection

@section('content')
<div>
	<h4 class="mt-3"> <span class="fas fa-syringe" ></span> {{ trans('practices.practices')}} </h4>
	
	<div class="table-responsive">
		<table class="table table-striped">
			<tr class="info">
				<th>  </th>
				<th> {{ trans('determinations.determination') }} </th>
				<th> {{ trans('practices.informed') }} </th>
				<th> {{ trans('practices.signed_off') }} </th>
				<th class="text-end"> {{ trans('forms.actions') }}</th>
			</tr>

			<form id="print_selection" action="{{ route('patients/protocols/generate_protocol', ['id' => $protocol->id]) }}" target="blank">
				@csrf

				<input type="hidden" name="id" value="{{ $protocol->id }}">
				
				@foreach ($protocol->internalPractices as $practice)
				<tr>
					<td style="width: 50px"> <input type="checkbox" class="form-check-input" name="filter_practices[]" value="{{ $practice->id }}" @if ($practice->signInternalPractices->isEmpty()) disabled @endif> </td>
					<td> {{ $practice->determination->name }} </td>
					
					<td>
						@if (empty($practice->result))
						<span class="badge bg-primary"> {{ trans('forms.no') }} </span>
						@else
						<span class="badge bg-success"> {{ trans('forms.yes') }} </span>
						@endif
					</td>

					<td>
						@forelse($practice->signInternalPractices as $sign)
						<a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
							<img height="30px" width="30px" src="{{ Gravatar::get($sign->user->email) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
						</a>
						@empty
						{{ trans('practices.not_signed')}}
						@endforelse
					</td>
					
					<td class="text-end">
						<a href="{{ route('patients/protocols/practices/show', ['id' => $practice->id]) }}" class="btn btn-primary btn-sm @if ($practice->signInternalPractices->isEmpty()) disabled @endif" title="{{ trans('practices.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>
					</td>
				</tr>
				@endforeach
			</form>
		</table>
	</div>
</div>
@endsection