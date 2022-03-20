@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.plans') }}
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
			<a class="nav-link" href="{{ route('administrators/settings/social_works/plans/create', ['social_work_id' => $social_work->id]) }}"> {{ trans('social_works.create_plan')}} </a>
		</li>

        <li class="nav-item">
			<a class="nav-link" href="{{ route('administrators/settings/social_works/edit', ['id' => $social_work->id]) }}"> {{ trans('forms.go_back')}} </a>
		</li>
	</ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('social_works.plans') }}
@endsection

@section('content')
<div class="mt-3">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> {{ trans('social_works.name') }} </th>
                    <th> {{ trans('nomenclators.nomenclator') }} </th>
                    <th> {{ trans('social_works.nbu_price') }} </th>
                    <th class="text-end"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($social_work->plans as $plan)
                <tr>
                    <td> {{ $plan->name }} </td>
                    <td> {{ $plan->nomenclator->name }} </td>
                    <td> ${{ $plan->nbu_price }} </td>

                    <td class="text-end">
                        <a href="{{ route('administrators/settings/social_works/plans/edit', ['id' => $plan->id]) }}" class="btn btn-info btn-sm" title="{{ trans('social_works.edit_plan') }}">
                            <i class="fas fa-edit fa-sm"> </i>
                        </a>

                        <a class="btn btn-info btn-sm" title="{{ trans('social_works.destroy_plan') }}" onclick="destroyPlan('{{ $plan->id }}')">
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