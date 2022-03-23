@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.create_social_work') }}
@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('social_works.create_social_work') }}
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/store') }}">
    @csrf

    <div class="col-9 mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection