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
    {{ trans('nomenclators.create_nomenclator') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('nomenclators.create_nomenclator') }}
@endsection


@section('content')

    <form method="post" action="{{ route('administrators/settings/nomenclators/store') }}" id="create_nomenclator">
        @csrf

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('nomenclators.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

            <input type="submit" class="d-none" id="submit-button">
        </div>
    </form>
@endsection

@section('content-footer')
<div class="card-footer">
	<div class="float-end">
		<button type="submit" class="btn btn-primary" onclick="submitForm()">
			<span class="fas fa-save"></span> {{ trans('forms.save') }}
		</button>
	</div>
</div>
@endsection
