@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
        function updateSocialWork() {
            var form = document.getElementById('update_social_work');
            form.submit();
        }
    </script>
@endsection

@section('title')
    {{ trans('social_works.update_social_work') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('social_works.update_social_work') }}
@endsection


@section('content')

    <form method="post" action="{{ route('administrators/settings/social_works/update', ['id' => $social_work->id]) }}"
          id="update_nomenclator">
        @csrf
        @method('PUT')

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                   value="{{ old('name') ?? $social_work->name }}" required>

            @error('name')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <input type="submit" style="display: none;">
    </form>
@endsection

@section('more-content')
    <div class="card-footer">
        <div class="float-right">
            <button type="submit" class="btn btn-primary" onclick="updateSocialWork();">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </div>
@endsection


@section('column-extra-content')
    <div class="card mt-3">
        <div class="card-header">
            <h4><i class="fas fa-sitemap"> </i> {{ trans('social_works.plans') }} </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="mySocialWorksTable">
                <thead>
                <tr>
                    <th> {{ trans('social_works.name') }} </th>
                    <th class="text-right"> {{ trans('forms.actions') }} </th>
                </tr>
                </thead>

                <tbody>
                @foreach ($social_work->plans as $plan)
                    <tr>
                        <td> {{ $plan->name }} </td>

                        <td class="text-right">
                            <a href="{{ route('administrators/settings/social_works/plans/edit', ['id' => $plan->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('determinations.show_determination') }}">
                                <i class="fas fa-edit fa-sm"> </i>
                            </a>

                            <a class="btn btn-info btn-sm" title="{{ trans('social_works.destroy_social_work') }}"
                               onclick="destroy_social_work('{{ $plan->id }}')">
                                <i class="fas fa-trash fa-sm"></i>
                            </a>

                            <form id="destroy_plan_{{ $plan->id }}" method="POST"
                                  action="{{ route('administrators/settings/social_works/plans/destroy', ['id' => $plan->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
