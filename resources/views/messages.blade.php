@section('messages')
    @if(isset($success) && count($success) > 0)
        <div class="alert alert-success mt-3">
        	<p> <strong> {{ trans('forms.successful_transaction') }} </strong> </p>
            <ul>
                @foreach ($success as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
           <p> <strong> {{ trans('errors.error_processing_transaction') }} </strong> </p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection