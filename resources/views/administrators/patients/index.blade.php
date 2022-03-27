@extends('administrators/default-template')

@section('title')
{{ trans('patients.patients') }}
@endsection

@section('js')
<script type="text/javascript">

    function destroyPatient(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_patient_'+form_id);
            form.submit();
        }
    }

    function load(page) {
        $("#page" ).val(page);
        document.all["select_page"].submit();
    }

    $(document).ready(function() {
        // Put the filter
        $("#filter" ).val("{{ $data['filter'] ?? '' }}");

        // Check a type
        $('input:radio[name="type"][value="{{ $data['type'] ?? '' }}"]').prop('checked', true);
    });
</script>
@endsection

@section('content-title')
<i class="fas fa-user-injured"></i> {{ trans('patients.patients') }}
@endsection

@section('active_patients', 'active')

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'animal']) }}"> {{ trans('patients.create_animal') }} </a>
        </li>
         
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'human']) }}"> {{ trans('patients.create_human') }} </a>
        </li>
         
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/create', ['type' => 'industrial']) }}"> {{ trans('patients.create_industrial') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content')
<form id="select_page">
    <!-- Patient type -->
    <div class="btn-group mt-3" role="group" aria-label="Patients filters">
        <input type="radio" class="btn-check" id="animalType" name="type" value="animal" required>
        <label class="btn btn-outline-primary" for="animalType"> {{ trans('patients.animal') }}</label>

        <input type="radio" class="btn-check" id="humanType" name="type" value="human" required>
        <label class="btn btn-outline-primary" for="humanType"> {{ trans('patients.human') }} </label>

        <input type="radio" class="btn-check" id="industrialType" name="type" value="industrial" required>
        <label class="btn btn-outline-primary" for="industrialType"> {{ trans('patients.industrial') }} </label>
    </div>

    <!-- Filter by keys -->
    <div class="form-group row">
        <div class="mt-3 col-md-6">
            <input type="text" class="form-control" id="filter" name="filter" placeholder="{{ trans('forms.enter_filter') }}">
        </div>

        <div class="mt-3 col-md-6">
            <button type="submit" class="btn btn-info" onclick="load(1)">
                <span class="fas fa-search" ></span> {{ trans('forms.search') }} </button>
            </div>
    </div>

    <input type="hidden" id="page" name="page" value="{{ $data['page'] }}">
</form>
@endsection