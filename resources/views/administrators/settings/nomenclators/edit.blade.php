@extends('administrators/settings/index')

@section('js')
<script type="text/javascript">
    function submitForm() 
	{
        let submitButton = $('#submit-button');
        submitButton.click();
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

    <div class="col-9 mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('nomenclators.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $nomenclator->name }}" required>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection