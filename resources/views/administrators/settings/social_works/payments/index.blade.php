@extends('administrators/settings/index')

@section('js')
<script type="text/javascript">
    function destroyPayment(form_id) {
        if (confirm('{{ trans('forms.confirm') }}')) {
            var form = document.getElementById('destroy_payment_' + form_id);
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/payments/create', ['social_work_id' => $social_work->id]) }}"> {{ trans('payment_social_works.create_payment')}} </a>
			</li>

            <li class="nav-item">
				<a class="nav-link" href="{{ route('administrators/settings/social_works/edit', ['id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
			</li>
	</ul>
</nav>
@endsection

@section('title')
{{ trans('payment_social_works.payments') }}
@endsection

@section('content-title')
<i class="fas fa-dollar-sign"> </i> {{ trans('payment_social_works.payments') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Here are detailed all the payments made by a social work
</p>
@endsection

@section('content')
<div class="mt-3">
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
                <td> {{ $payment->billing_period->name }} </td>

                <td>
                    @if (!empty($payment->payment_date))
                    {{ date('d/m/Y', strtotime($payment->payment_date)) }}
                    @endif
                </td>

                <td> ${{ $payment->amount }} </td>

                <td class="text-end">
                    <a href="{{ route('administrators/settings/social_works/payments/edit', ['id' => $payment->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('payment_social_works.edit_payment') }}">
                        <i class="fas fa-edit fa-sm"> </i>
                    </a>

                    <a class="btn btn-primary btn-sm" title="{{ trans('payment_social_works.destroy_payment') }}" onclick="destroyPayment('{{ $payment->id }}')">
                        <i class="fas fa-trash fa-sm"></i>
                    </a>

                    <form id="destroy_payment_{{ $payment->id }}" method="POST" action="{{ route('administrators/settings/social_works/payments/destroy', ['id' => $payment->id]) }}">
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
