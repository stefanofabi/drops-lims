@extends('default-filter') 

@section('title')
{{ trans('protocols.protocols') }}
@endsection 

@section('main-title')
{{ trans('protocols.protocols') }}
@endsection

@section('create-href')
{{ route('protocols/create') }}
@endsection

@section('create-text')
{{ trans('protocols.create_protocols') }}
@endsection 

@section('active_protocols', 'active')

@section('js')
    <script type="text/javascript">
     $(document).ready(function() {
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
    <div class="col-md-4">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('prescribers.enter_filter') }}">
    </div>

    <div class="col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('prescribers.search') }} </button>
        </div>
</div>
@endsection 