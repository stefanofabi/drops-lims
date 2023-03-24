@extends('administrators/default-template')

@section('title')
{{ trans('profiles.change_signature') }}
@endsection

@section('js')
<script type="text/javascript">
    function destroySignature() 
    {
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_signature');
            form.submit();
        }
    }
</script>
@endsection

@section('menu')
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/profiles/edit', ['id' => $user->id]) }}"> {{ trans('profiles.my_profile') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @cannot('sign practices') disabled @endcannot" href="{{ route('administrators/profiles/signatures/edit', ['id' => $user->id]) }}"> {{ trans('profiles.change_signature') }} </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('passwords/change', ['id' => $user->id]) }}"> {{ trans('auth.change_password') }} </a>
        </li>
    </ul>
</nav>
@endsection

@section('content-title')
<i class="fa-solid fa-signature"></i> {{ trans('profiles.change_signature') }}
@endsection

@section('content-message')
<p class="text-justify pe-5">
    {{ trans('profiles.change_signature_edit_message') }}
</p>
@endsection

@section('content')
<div class="mt-3">

    <p>
        @if (empty($user->signature))
        <h3> {{ trans('profiles.signature_not_loaded') }} </h3>
        @else
        <img src="{{ asset('storage/signatures/'.$user->signature) }}" class="img-thumbnail" style="--bs-bg-opacity: 0.3" alt="{{ $user->full_name }} signature" height="200" width="200">
        @endif
    </p>

    <p>
        <small id="signatureHelp" class="form-text text-muted"> {{ trans('profiles.signature_help') }} </small>
    </p>

    <form method="post" action="{{ route('administrators/profiles/signatures/update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label" for="signature"> {{ trans('profiles.select_image') }}: </label>
                
                <input type="file" name="signature" id="signature" class="form-control @error('signature') is-invalid @enderror" required>
                @error('signature') <span class="text-danger"> {{ $message }} </span> @enderror
            </div>
        </div>

        <input type="submit" class="btn btn-lg btn-primary float-start mt-4" value="{{ trans('forms.upload') }}">
    </form>

    <a href="#" class="btn btn-lg btn-danger float-start mt-4 ms-3" onclick="destroySignature()"> {{ trans('profiles.destroy_signature') }} </a>

    <form id="destroy_signature" method="POST" action="{{ route('administrators/profiles/signatures/destroy', ['id' => $user->id]) }}">
	    @csrf
	    @method('DELETE')
	</form>
</div> 
@endsection
