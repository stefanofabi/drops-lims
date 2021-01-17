@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">

        function createSocialWork() {
            var form = document.getElementById('create_social_work');
            form.submit();
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

    <form method="post" action="{{ route('administrators/settings/social_works/store') }}" id="create_social_work">
        @csrf

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

            @error('name')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>
    </form>
@endsection

@section('more-content')
    <div class="card-footer">
        <div class="float-right">
            <button type="submit" class="btn btn-primary" onclick="createSocialWork();">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </div>
@endsection
