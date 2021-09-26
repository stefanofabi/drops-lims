@extends('patients/default-template')

@section('title')
{{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection

@section('active_results', 'active')

@section('menu-title')
{{ trans('forms.menu') }}
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function print_selection() {
            $('#print_selection').submit();
        }
    </script>
@endsection

@section('menu')
<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" target="_blank" href=""> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('protocols.print_report') }} </a>
	</li>
</ul>
@endsection

@section('content-title')
<i class="fas fa-file-medical"></i> {{ trans('protocols.show_protocol') }} #{{ $protocol->id }}
@endsection


@section('content')

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('patients.patient') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->patient->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->plan->social_work->name }} {{ $protocol->plan->name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('prescribers.prescriber') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->prescriber->full_name }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.completion_date') }} </span>
		</div>

		<input type="date" class="form-control" value="{{ $protocol->completion_date }}" disabled>
	</div>

	<div class="input-group mt-2 mb-1 col-md-9 input-form">
		<div class="input-group-prepend">
			<span class="input-group-text"> {{ trans('protocols.diagnostic') }} </span>
		</div>

		<input type="text" class="form-control" value="{{ $protocol->diagnostic }}" disabled>
	</div>
@endsection

@section('extra-content')

<div class="card mt-3 mb-4">
	<div class="card-header">
        <div class="btn-group float-end">
            <button type="button" class="btn btn-primary" onclick="print_selection()">{{ trans('protocols.print_selected') }}</button>
        </div>

        <h4> <span class="fas fa-syringe" ></span> {{ trans('determinations.determinations')}} </h4>
    </div>

    <div class="table-responsive">
		<table class="table table-striped">
				<tr class="info">
                    <th>  </th>
					<th> {{ trans('determinations.determination') }} </th>
					<th> {{ trans('determinations.amount') }} </th>
					<th> {{ trans('protocols.informed') }} </th>
					<th class="text-end"> {{ trans('forms.actions') }}</th>
				</tr>

                <form id="print_selection" action="{{ route('patients/protocols/print_selection') }}" method="post" target="_blank">
                   @csrf

                    @foreach ($protocol->practices as $practice)
                        <tr>
                            <td style="width: 50px"> <input type="checkbox" name="to_print[]" value="{{ $practice->id }}"> </td>
                            <td> {{ $practice->report->determination->name }} </td>
                            <td> $ {{ number_format($practice->amount, 2, ",", ".") }} </td>
                            <td>
                                @forelse($practice->signs as $sign)
                                    <a style="text-decoration: none" href="#" data-toggle="tooltip" title="{{ $sign->user->name }}">
                                        <img height="30px" width="30px" src="{{ asset('storage/avatars/'.$sign->user->avatar) }}" class="rounded-circle" alt="{{ $sign->user->name }}">
                                    </a>
                                @empty
                                    {{ trans('protocols.not_signed')}}
                                @endforelse
                            </td>
                            <td class="text-end">
                                <a href="{{ route('patients/protocols/practices/show', ['id' => $practice->id]) }}" class="btn btn-info btn-sm" title="{{ trans('protocols.show_practice') }}"> <i class="fas fa-eye fa-sm"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </form>
		</table>
	</div>
</div>
@endsection

