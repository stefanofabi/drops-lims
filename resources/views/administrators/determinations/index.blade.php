@extends('administrators/determinations/determinations')

@section('js')
    @parent

    <script type="text/javascript">
        function destroy_determination(form_id) {
            if (confirm('{{ trans("forms.confirm") }}')) {
                var form = document.getElementById('destroy_determination_' + form_id);
                form.submit();
            }
        }
    </script>
@endsection

@section('results')
    @if (!sizeof($determinations))
        <div class="col-md-12"> {{ trans('forms.no_results') }}</div>
    @else

        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th> {{ trans('determinations.code') }} </th>
                    <th> {{ trans('determinations.determination') }} </th>
                    <th class="text-right"> {{ trans('forms.actions') }} </th>
                </tr>

                @foreach ($determinations as $determination)
                    <tr>
                        <td> {{ $determination->code }} </td>
                        <td> {{ $determination->name }} </td>

                        <td class="text-right">
                            <a href="{{ route('administrators/determinations/show', ['id' => $determination->id]) }}"
                               class="btn btn-info btn-sm" title="{{ trans('determinations.show_determination') }}"> <i
                                    class="fas fa-eye fa-sm"></i> </a>
                            <a class="btn btn-info btn-sm" title="{{ trans('determinations.destroy_determination') }}"
                               onclick="destroy_determination('{{ $determination->id }}')"> <i
                                    class="fas fa-trash fa-sm"></i> </a>

                            <form id="destroy_determination_{{ $determination->id }}" method="POST"
                                  action="{{ route('administrators/determinations/destroy', ['id' => $determination->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach


                <tr>
                    <td colspan="7">
					<span class="float-right">
						{!! $paginate !!}
					</span>
                    </td>
                </tr>

            </table>
        </div>
    @endif

@endsection
