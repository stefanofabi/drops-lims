@extends('administrators/settings/index')

@section('title')
{{ trans('social_works.create_social_work') }}
@endsection

@section('content-title')
<i class="fas fa-archive"> </i> {{ trans('social_works.create_social_work') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    Social works are assigned to patients and protocols. They are required to be able to invoice the practices performed to the patients
</p>
@endsection

@section('content')
<form method="post" action="{{ route('administrators/settings/social_works/store') }}">
    @csrf

    <div class="col-md-6">
        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.name') }} </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" aria-describedby="nameHelp" required>
                        
            <small id="nameHelp" class="form-text text-muted"> Full name of the social work </small>
        </div>

        <div class="form-group mt-2">
            <label for="name"> {{ trans('social_works.acronym') }} </label>
            <input type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" id="acronym" value="{{ old('acronym') }}" aria-describedby="acronymHelp" required>
                        
            <small id="acronymHelp" class="form-text text-muted"> The most significant initials of the name to be able to quickly search for a social work </small>
        </div>
    </div>

    <input type="submit" class="btn btn-lg btn-primary mt-3" value="{{ trans('forms.save') }}">
</form>
@endsection