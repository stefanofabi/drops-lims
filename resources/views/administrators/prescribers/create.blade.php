@extends('administrators/default-template')

@section('js')
    <script type="text/javascript">
        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }
    </script>
@endsection

@section('title')
    {{ trans('prescribers.create_prescriber') }}
@endsection

@section('active_prescribers', 'active')

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#"> <img src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.no_options') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-user-md"></i> {{ trans('prescribers.create_prescriber') }}
@endsection


@section('content')
    <form method="post" action="{{ route('administrators/prescribers/store') }}">
        @csrf

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.full_name') }} </span>
            </div>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name"
                   value="{{ old('full_name') }}" required>

            @error('full_name')
            <span class="invalid-feedback" role="alert">
                <strong> {{ $message }} </strong>
            </span>
            @enderror
        </div>

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.phone') }} </span>
            </div>

            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.email') }} </span>
            </div>

            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong> {{ $message }} </strong>
            </span>
            @enderror
        </div>

        <div class="input-group mt-2 col-md-9 input-form">
            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.provincial_enrollment') }} </span>
            </div>
            <input type="number" class="form-control" name="provincial_enrollment" min="0"
                   value="{{ old('provincial_enrollment') }}">

            <div class="input-group-prepend">
                <span class="input-group-text"> {{ trans('prescribers.national_enrollment') }} </span>
            </div>
            <input type="number" class="form-control" name="national_enrollment" min="0"
                   value="{{ old('national_enrollment') }}">
        </div>

        <input id="submit-button" type="submit" style="display: none;">
    </form>
@endsection

@section('content-footer')
    <div class="float-end">
        <button type="submit" onclick="send()" class="btn btn-primary">
        	<span class="fas fa-save"></span> {{ trans('forms.save') }}
        </button>
    </div>
@endsection

