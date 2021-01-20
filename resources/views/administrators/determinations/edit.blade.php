@extends('administrators/default-template')

@section('title')
    {{ trans('determinations.edit_determination') }}
@endsection

@section('active_determinations', 'active')

@section('js')
    <script type="text/javascript">
        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

        function destroy_report(form_id) {
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
                <a class="nav-link"
                   href="{{ route('administrators/determinations/reports/create', ['determination_id' => $determination->id]) }}">
                    <img src="{{ asset('images/drop.png') }}" width="25"
                         height="25"> {{ trans('reports.create_report') }} </a>
            </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/show', ['id' => $determination->id]) }}">
                <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-edit"></i> {{ trans('determinations.edit_determination') }}
@endsection


@section('content')
    <form method="post" action="{{ route('administrators/determinations/update', $determination->id) }}">
        @csrf
        {{ method_field('PUT') }}

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('determinations.nbu') }} </span>
            </div>

            <input type="text" class="form-control" value="{{ $determination->nomenclator->name }}" disabled>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('determinations.code') }} </span>
            </div>

            <input type="number" class="form-control" name="code" min="0" value="{{ $determination->code }}" required>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('determinations.name') }} </span>
            </div>

            <input type="text" class="form-control" name="name" value="{{ $determination->name }}" required>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('determinations.position') }} </span>
            </div>

            <input type="number" class="form-control" name="position" min="1" value="{{ $determination->position }}"
                   required>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('determinations.biochemical_unit') }} </span>
            </div>

            <input type="number" class="form-control" name="biochemical_unit" min="0" step="0.01"
                   value="{{ $determination->biochemical_unit }}" required>
        </div>

        <input id="submit-button" type="submit" style="display: none;">
    </form>
@endsection

@section('more-content')
    <div class="card-footer">
        <div class="mt-2 float-right">
            <button onclick="send()" type="submit" class="btn btn-primary">
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
                    <th class="text-right"> {{ trans('forms.actions') }}</th>
                </tr>

                @foreach ($determination->reports as $report)
                    <tr>
                        <td> {{ $report->name }} </td>
                        <td class="text-right" style="width: 400px">
                            <a href="{{ route('administrators/determinations/reports/edit', ['id' => $report->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('reports.edit_report') }}"> <i
                                    class="fas fa-edit fa-sm"></i> </a>

                            <a class="btn btn-info btn-sm" title="{{ trans('reports.destroy_report') }}"
                               onclick="destroy_report('{{ $report->id }}')"> <i class="fas fa-trash fa-sm"></i> </a>

                            <form id="destroy_report_{{ $report->id }}" method="POST"
                                  action="{{ route('administrators/determinations/reports/destroy', ['id' => $report->id]) }}">
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
