@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
        function updateNomenclator() {
            var form = document.getElementById('update_nomenclator');
            form.submit();
        }
    </script>
@endsection

@section('title')
    {{ trans('nomenclators.update_nomenclator') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('nomenclators.update_nomenclator') }}
@endsection


@section('content')

    <form method="post" action="{{ route('administrators/settings/nomenclators/update', ['id' => $nomenclator->id]) }}" id="update_nomenclator">
        @csrf
        @method('PUT')

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('nomenclators.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $nomenclator->name }}" required>

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
            <button type="submit" class="btn btn-primary" onclick="updateNomenclator();">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </div>
@endsection
