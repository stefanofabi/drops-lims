@extends('administrators/settings/index')

@section('js')
    <script>
        $(document).ready(function () {
            $('#myNomenclatorsTable').DataTable();
        });
    </script>
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-striped" id="myNomenclatorsTable">
            <thead>
                <tr>
                    <th> {{ trans('nomenclators.name') }} </th>
                    <th class="text-right"> {{ trans('forms.actions') }} </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($nomenclators as $nomenclator)
                    <tr>
                        <td> {{ $nomenclator->name }} </td>

                        <td class="text-right">
                            <a href="{{ route('administrators/settings/nomenclators/edit', ['id' => $nomenclator->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('determinations.show_determination') }}">
                                <i class="fas fa-edit fa-sm"> </i>
                            </a>
                            <a class="btn btn-info btn-sm" title="{{ trans('nomenclators.destroy_nomenclator') }}"
                               onclick="destroy_nomenclator('{{ $nomenclator->id }}')">
                                <i class="fas fa-trash fa-sm"></i>
                            </a>

                            <form id="destroy_nomenclator_{{ $nomenclator->id }}" method="POST"
                                  action="{{ route('administrators/settings/nomenclators/destroy', ['id' => $nomenclator->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
