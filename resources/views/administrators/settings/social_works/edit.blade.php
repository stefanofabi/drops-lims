@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
        function destroy_payment(form_id) {
            if (confirm('{{ trans('forms.confirm') }}')) {
                var form = document.getElementById('destroy_payment_' + form_id);
                form.submit();
            }
        }
    </script>
@endsection

@section('title')
    {{ trans('social_works.edit_social_work') }}
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
	        <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/index', ['social_work_id' => $social_work->id]) }}"> {{ trans('social_works.plans')}} </a>
			</li>

            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/index') }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('social_works.edit_social_work') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/update', ['id' => $social_work->id]) }}">
    @csrf
    @method('PUT')

    <div class="col-9 mt-3">
        <div class="input-group input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $social_work->name }}" required>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>

<hr>

    <div class="mt-3">
        <h4><i class="fas fa-cash-register"> </i> {{ trans('payment_social_works.payments') }} </h4>
     
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th> {{ trans('billing_periods.billing_period') }} </th>
                    <th> {{ trans('payment_social_works.payment_date') }} </th>
                    <th> {{ trans('payment_social_works.payment_amount') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>

                @forelse ($payments as $payment)
                    <tr>
                        <td> {{ $payment->billing_period }} </td>

                        <td>
                            @if (!empty($payment->payment_date))
                                {{ date('d/m/Y', strtotime($payment->payment_date)) }}
                            @endif
                        </td>

                        <td> ${{ $payment->amount }} </td>

                        <td class="text-end">
                            <a href="{{ route('administrators/settings/social_works/payments/edit', ['id' => $payment->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('payment_social_works.edit_payment') }}">
                                <i class="fas fa-edit fa-sm"> </i>
                            </a>

                            <a class="btn btn-info btn-sm" title="{{ trans('payment_social_works.destroy_payment') }}"
                               onclick="destroy_payment('{{ $payment->id }}')">
                                <i class="fas fa-trash fa-sm"></i>
                            </a>

                            <form id="destroy_payment_{{ $payment->id }}" method="POST"
                                  action="{{ route('administrators/settings/social_works/payments/destroy', ['id' => $payment->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4"> {{ trans('forms.no_data') }}</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection