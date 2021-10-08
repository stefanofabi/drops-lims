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
    {{ trans('social_works.create_social_work') }}
@endsection

@section('content-title')
    <i class="fas fa-archive"> </i> {{ trans('social_works.create_social_work') }}
@endsection

@section('content')
    <form method="post" action="{{ route('administrators/settings/social_works/store') }}">
        @csrf

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
        </div>

        <input type="submit" class="d-none" id="submit-button">
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