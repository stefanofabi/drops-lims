@extends('administrators/default-filter')

@section('title')
{{ trans('determinations.determinations') }}
@endsection

@section('main-title')
<i class="fas fa-microscope"></i> {{ trans('determinations.determinations') }}
@endsection

@section('create-href')
{{ route('administrators/determinations/create') }}
@endsection

@section('create-text')
<span class="fas fa-syringe" ></span> {{ trans('determinations.create_determination') }}
@endsection

@section('active_determinations', 'active')

@section('js')
<script type="text/javascript">
   $(document).ready(function() {
        // Select a nomenclator
        $('#nomenclator').val("{{ $request['nomenclator'] ?? '' }}")

        // Put the filter
        $("#filter" ).val('{{ $request['filter'] ?? '' }}');
    });

   function load(page) {
        $("#page" ).val(page);
        document.all["select_page"].submit();
    }
</script>
@endsection

@section('filters')
<!-- Filter by keys -->
<div class="form-group row">
    <div class="col-md-3">
        <select class="form-control input-sm" id="nomenclator" name="nomenclator" required>
            <option value=""> {{ trans('forms.select_option') }} </option>
            @foreach ($nomenclators as $nomenclator)
            <option value="{{ $nomenclator['id'] }}"> {{ $nomenclator['name'] }} </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <div class="mt-2 col-md-6">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
    </div>

    <div class="mt-2 col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
        </div>
    </div>
@endsection