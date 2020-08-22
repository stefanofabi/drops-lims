@section('messages')
    @if (isset($success_messages) && count($success_messages) > 0)
        <div class="alert alert-success">
        	<p> <strong> {{ trans('forms.successful_transaction') }} </strong> </p>
            <ul>
                @foreach ($success_messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
           <p> <strong> {{ trans('errors.error_processing_transaction') }} </strong> </p>

           <ul>
                @foreach ($errors as $message)
                    <li> {{ $message }} </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection