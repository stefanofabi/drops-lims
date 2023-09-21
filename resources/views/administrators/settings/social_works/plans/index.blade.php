@extends('administrators/settings/index')

@section('title')
{{ trans('plans.plans') }}
@endsection

@section('js')
    <script type="text/javascript">
        function destroyPlan(form_id) {
            if (confirm('{{ trans('forms.confirm') }}')) {
                var form = document.getElementById('destroy_plan_' + form_id);
                form.submit();
            }
        }
    </script>
@endsection

@section('menu')
<nav class="navbar">
	<ul class="navbar-nav">
        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/create', ['social_work_id' => $social_work->id]) }}"> {{ trans('plans.create_plan')}} </a>
		</li>

        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/edit', ['id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-list-check"></i> {{ trans('plans.plans') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('plans.plans_index_message') }} 
</p>
@endsection

@section('content')
<div class="mt-3">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> {{ trans('social_works.name') }} </th>
                    <th> {{ trans('nomenclators.nomenclator') }} </th>
                    <th> {{ trans('plans.nbu_price') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($social_work->plans as $plan)
                <tr>
                    <td> {{ $plan->name }} </td>
                    <td> {{ $plan->nomenclator->name }} </td>
                    <td> ${{ number_format($plan->nbu_price, Drops::getSystemParameterValueByKey('DECIMALS'), Drops::getSystemParameterValueByKey('DECIMAL_SEPARATOR'), Drops::getSystemParameterValueByKey('THOUSANDS_SEPARATOR')) }} </td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/social_works/plans/edit', ['id' => $plan->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('plans.edit_plan') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-primary btn-sm" title="{{ trans('plans.destroy_plan') }}" onclick="destroyPlan('{{ $plan->id }}')">
                            <i class="fas fa-trash fa-sm"></i>
                        </a>

                        <form id="destroy_plan_{{ $plan->id }}" method="POST" action="{{ route('administrators/settings/social_works/plans/destroy', ['id' => $plan->id]) }}">
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
            </tbody>
        </table>
    </div>
</div>
@endsection