@extends('patients/default-template')

@section('title')
{{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_protocols', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

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
			<a class="nav-link @if (empty($protocol->closed)) disabled @endif" target="blank" href="{{ route('patients/protocols/print', $protocol->id) }}"> {{ trans('protocols.print_report') }} </a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="#" onclick="printSelection()"> {{ trans('protocols.print_selected') }} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection

@section('content')
<div class="col-10">
	<div class="input-group mt-3 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->patient->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->plan->social_work->name }} {{ $protocol->plan->name }}" disabled>
	</div>

	<div class="input-group mt-2 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->prescriber->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" value="{{ $protocol->completion_date }}" disabled>
	</div>

	<div class="input-group mt-2 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->diagnostic }}" disabled>
	</div>
</div>

<h4 class="mt-3"> <span class="fas fa-syringe" ></span> {{ trans('practices.practices')}} </h4>
    

<div class="table-responsive">
	<table class="table table-striped">
		<tr class="info">
            <th>  </th>
			<th> {{ trans('practices.practice') }} </th>
			<th> {{ trans('practices.informed') }} </th>
			<th class="text-end"> {{ trans('forms.actions') }}</th>
		</tr>

        <form id="print_selection" action="{{ route('patients/protocols/print_selection') }}" method="post" target="blank">
            @csrf

			<input type="hidden" name="id" value="{{ $protocol->id }}">
			
            @foreach ($protocol->practices as $practice)
            <tr>
                <td style="width: 50px"> <input type="checkbox" name="filter_practices[]" value="{{ $practice->id }}"> </td>
                <td> {{ $practice->report->determination->name }} </td>

                <td>
                    @forelse($practice->signs as $sign)
                    <a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
                        <img height="30px" width="30px" src="{{ Gravatar::get($sign->user->email) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
                    </a>
                    @empty
                    {{ trans('practices.not_signed')}}
                    @endforelse
                </td>
                
				<td class="text-end">
                    <a href="{{ route('patients/protocols/practices/show', ['id' => $practice->id]) }}" class="btn btn-info btn-sm @if ($practice->signs->isEmpty()) disabled @endif" title="{{ trans('practices.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>
                </td>
            </tr>
            @endforeach
        </form>
	</table>
</div>
@endsection