@section('messages')
    @if (isset($success_messages))
        <div class="alert alert-success">
        	<p><strong> Transacción realizada con éxito </strong> </p>
            <ul>
                @foreach ($success_messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
        	<p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection