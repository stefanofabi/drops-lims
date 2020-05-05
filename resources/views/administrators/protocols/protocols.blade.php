@extends('administrators/default-filter') 

@section('title')
{{ trans('protocols.protocols') }}
@endsection 

@section('main-title')
<span class="fas fa-file-medical" ></span> {{ trans('protocols.protocols') }}
@endsection

@section('create-href')
{{ route('administrators/protocols/our/create') }}
@endsection

@section('create-text')
<span class="fas fa-plus" ></span> {{ trans('protocols.create_protocol') }}
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
    <div class="col-md-6">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
    </div>

    <div class="col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
        </div>
</div>
@endsection 

@section('action_page')
{{ route('administrators/protocols/load') }}
@endsection