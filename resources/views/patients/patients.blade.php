@extends('default-filter') 

@section('title')
{{ trans('patients.patients') }}
@endsection 

@section('main-title')
{{ trans('patients.patients') }}
@endsection

@section('create-href')
{{ route('patients/create') }}
@endsection

@section('create-text')
{{ trans('patients.create_patient') }}
@endsection 

@section('active_patients', 'active')

@section('js')
    <script type="text/javascript">
     $(document).ready(function() {
        // Put the filter
        $("#filter" ).val('{{ $request['filter'] ?? '' }}');

        // Select a shunt from list
        $("#shunt option[value='{{ $request['shunt'] ?? '' }}']").attr("selected",true);

        // Check a type
        $('input:radio[name="type"][value="{{ $request['type'] ?? '' }}"]').prop('checked', true);
    });

     function load(page) {
        $("#page" ).val(page);
        document.all["select_page"].submit();
     }
    </script>
@endsection

@section('filters') 
<!-- Tipo de paciente -->
<div class="col form-group row">
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="tipoAnimal" name="type" value="animals" required>
        <label class="custom-control-label" for="tipoAnimal"> {{ trans('patients.animal') }}</label>
    </div>

    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="tipoHumano" name="type" value="humans" required>
        <label class="custom-control-label" for="tipoHumano"> {{ trans('patients.human') }} </label>
    </div>

    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="tipoIndustrial" name="type" value="industrials" required>
        <label class="custom-control-label" for="tipoIndustrial"> {{ trans('patients.industrial') }} </label>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-3">
        <select class="form-control input-sm" id="shunt" name="shunt" required>
            <option value=""> {{ trans('patients.select_shunt') }}</option>
            @foreach($shunts as $shunt)
                <option value="{{ $shunt->id }}"> {{ $shunt->name}} </option>
            @endforeach 
        </select>
    </div>
</div>

<!-- Filtro por claves -->
<div class="form-group row">
    <div class="col-md-4">
        <input type="text" class="form-control form-control" id="filter" name="filter" placeholder="{{ trans('patients.enter_filter') }}">
    </div>

    <div class="col-md-6">
        <button type="submit" class="btn btn-info">
            <span class="fas fa-search" ></span> {{ trans('patients.search') }} </button>
        </div>
</div>
@endsection 