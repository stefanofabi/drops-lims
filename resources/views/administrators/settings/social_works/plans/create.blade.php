@extends('administrators/settings/index')

@section('js')
    <script type="text/javascript">
        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

        $(document).ready(function () {
            // Select a nomenclator from list
            $("#nomenclator").val("{{ old('nomenclator_id') }}");
        });
    </script>
@endsection

@section('title')
    {{ trans('social_works.create_plan') }}
@endsection

@section('content-title')
    <i class="fas fa-plus"> </i> {{ trans('social_works.create_plan') }}
@endsection


@section('content')

    <div class="input-group mt-2 mb-1 col-md-9 input-form">
        <div class="input-group-prepend">
            <span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
        </div>

        <input type="text" class="form-control" value="{{ $social_work->name }}" readonly>
    </div>

    <form method="post" action="{{ route('administrators/settings/social_works/plans/store') }}">
        @csrf

        <input type="hidden" name="social_work_id" value="{{ $social_work->id }}">

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('nomenclators.name') }} </span>
            </div>

            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>

            @error('name')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('nomenclators.nomenclator') }} </span>
            </div>

            <select id="nomenclator" class="form-control" name="nomenclator_id">
                <option value=""> {{ trans('forms.select_option') }}</option>
                @foreach ($nomenclators as $nomenclator)
                    <option value="{{ $nomenclator->id }}"> {{ $nomenclator->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-group mt-2 mb-1 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('social_works.nbu_price') }} </span>
            </div>

            <input type="number" step="0.01" class="form-control @error('nbu_price') is-invalid @enderror"
                   name="nbu_price"
                   value="{{ old('nbu_price') }}" required>

            @error('nbu_price')
            <span class="invalid-feedback" role="alert">
            	<strong> {{ $message }} </strong>
       		</span>
            @enderror
        </div>

        <input id="submit-button" type="submit" style="display: none;">
    </form>
@endsection

@section('more-content')
    <div class="card-footer">
        <div class="float-right">
            <button type="submit" class="btn btn-primary" onclick="send();">
                <span class="fas fa-save"></span> {{ trans('forms.save') }}
            </button>
        </div>
    </div>
@endsection
