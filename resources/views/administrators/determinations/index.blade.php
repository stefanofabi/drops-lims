@extends('administrators/default-template')

@section('title')
{{ trans('determinations.determinations') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">
    function load(page)
    {
        $("#page" ).val(page);
        document.all["select_page"].submit();
    }

    function destroyDetermination(form_id) 
    {
        if (confirm('{{ trans("forms.confirm") }}')) 
        {
            var form = document.getElementById('destroy_determination_' + form_id);
            form.submit();
        }
    }
</script>

<script type="module">
    $(document).ready(function() {
        // Select a nomenclator
        $('#nomenclator').val("{{ $nomenclator }}");

        // Put the filter
        $("#filter" ).val("{{ $filter }}");
    });
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/determinations/create') }}"> {{ trans('determinations.create_determination') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fas fa-syringe"></i> {{ trans('determinations.determinations') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('determinations.determinations_message') }}
</p>
@endsection

@section('content')
<form id="select_page">
    <!-- Filter by keys -->
    <div class="form-group row mt-3">
        <div class="col-md-6">
            <select class="form-select" name="nomenclator_id" id="nomenclator" required>
                <option value=""> {{ trans('forms.select_option') }} </option>
                
                @foreach ($nomenclators as $nomenclator)
                <option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="mt-2 col-md-6">
            <input type="text" class="form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
        </div>

        <div class="mt-2 col-md-6">
            <button type="submit" class="btn btn-primary" onclick="load(1)">
                <span class="fas fa-search" ></span> {{ trans('forms.search') }} 
            </button>
        </div>
    </div>

    <input type="hidden" id="page" name="page" value="{{ $page }}">
</form>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <tr>
            <th> {{ trans('determinations.code') }} </th>
            <th> {{ trans('determinations.determination') }} </th>
            <th class="text-end"> {{ trans('forms.actions') }} </th>
        </tr>

        @foreach ($determinations as $determination)
        <tr>
            <td> {{ $determination->code }} </td>
            <td> {{ $determination->name }} </td>

            <td class="text-end">
                <a href="{{ route('administrators/determinations/edit', ['id' => $determination->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('determinations.edit_determination') }}"> <i class="fas fa-edit fa-sm"></i> </a>

                <a class="btn btn-primary btn-sm verticalButtons" title="{{ trans('determinations.destroy_determination') }}" onclick="destroyDetermination('{{ $determination->id }}')"> <i class="fas fa-trash fa-sm"></i> </a>

                <form id="destroy_determination_{{ $determination->id }}" method="POST" action="{{ route('administrators/determinations/destroy', ['id' => $determination->id]) }}">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{!! $paginate !!}
@endsection
